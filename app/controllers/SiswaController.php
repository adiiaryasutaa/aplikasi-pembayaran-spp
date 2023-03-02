<?php

namespace App\Controller;

use App\Model\Kelas;
use App\Model\Pembayaran;
use App\Model\Pengguna;
use App\Model\Siswa;
use App\View\Layout\Dashboard;
use Core\Auth\Role;
use Core\Foundation\Facade\DB;
use Core\Http\Controller;
use Core\Validation\Rule;
use Core\Validation\Validator;
use Exception;

class SiswaController extends Controller
{
	public function index()
	{
		$siswa = (new Siswa)->all();
		$kelas = (new Kelas)->all();
		$pembayaran = (new Pembayaran)->all();

		return view('siswa/index')
			->with(compact('siswa', 'kelas', 'pembayaran'))
			->useLayout(new Dashboard);
	}

	public function create()
	{
		$inputs = [
			'nisn' => $this->request('nisn'),
			'nis' => $this->request('nis'),
			'nama' => $this->request('nama'),
			'alamat' => $this->request('alamat'),
			'telepon' => $this->request('nomor-telepon'),
			'username' => $this->request('username'),
			'password' => $this->request('password'),
			'kelas' => $this->request('kelas'),
			'pembayaran' => $this->request('pembayaran'),
		];

		$validator = Validator::make($inputs, [
			'nisn' => [Rule::required(), Rule::number(), Rule::max(10), Rule::unique('siswa', 'nisn')],
			'nis' => [Rule::required(), Rule::number(), Rule::max(5), Rule::unique('siswa', 'nisn')],
			'nama' => [Rule::required(), Rule::max(50)],
			'alamat' => [Rule::required(), Rule::min(4)],
			'telepon' => [Rule::required(), Rule::max(14)],
			'username' => [Rule::required(), Rule::max(25), Rule::unique('pengguna', 'username')],
			'password' => [Rule::required(), Rule::max(20)],
			'kelas' => [Rule::required(), Rule::exists('kelas', 'id')],
			'pembayaran' => [Rule::required(), Rule::exists('pembayaran', 'id')],
		])->validate();

		if ($validator->error()) {
			return back()->withError($validator->getErrors());
		}

		$validated = $validator->getValidated();
		$validated['password'] = password_hash($validated['password'], PASSWORD_BCRYPT);

		try {
			DB::beginTransaction();

			$dataPengguna = array_merge(array_intersect_key($validated, ['username' => 'username', 'password' => 'password']), ['role' => Role::SISWA]);
			$pengguna = (new Pengguna);

			if (!$pengguna->insert($dataPengguna)) {
				throw new Exception("Failed insert into table pengguna");
			}

			$pengguna->whereFirst(['username' => $validated['username']]);

			$dataSiswa = array_merge(
				array_diff_key($validated, ['username' => 'username', 'password' => 'password']),
				['pengguna_id' => $pengguna->id]
			);

			$dataSiswa['kelas_id'] = $dataSiswa['kelas'];
			$dataSiswa['pembayaran_id'] = $dataSiswa['pembayaran'];
			unset($dataSiswa['kelas'], $dataSiswa['pembayaran']);

			if (!(new Siswa)->insert($dataSiswa)) {
				throw new Exception("Failed insert into siswa");
			}

			DB::commit();

			return back()->with('create-siswa-success', 'Siswa berhasil ditambahkan');
		} catch (Exception $ex) {
			DB::rollback();

			return back()->with('create-siswa-failed', 'Siswa gagal ditambahkan');
		}
	}

	public function show(int $id)
	{
		$siswa = (new Siswa)->getDetailWhereFirst(['siswa.id' => $id]);
		$kelas = (new Kelas)->all();
		$pembayaran = (new Pembayaran)->all();

		return view('siswa/detail')
			->with(compact('siswa', 'kelas', 'pembayaran'))
			->useLayout(new Dashboard);
	}

	public function update(int $id)
	{
		$inputs = [
			'nisn' => $this->request('nisn'),
			'nis' => $this->request('nis'),
			'nama' => $this->request('nama'),
			'alamat' => $this->request('alamat'),
			'telepon' => $this->request('nomor-telepon'),
			'username' => $this->request('username'),
			'password' => $this->request('password'),
			'kelas' => $this->request('kelas'),
			'pembayaran' => $this->request('pembayaran'),
		];

		$siswa = (new Siswa)->getDetailWhereFirst(['siswa.id' => $id]);

		$validator = Validator::make($inputs, [
			'nisn' => [Rule::required(), Rule::number(), Rule::max(10), Rule::unique('siswa', 'nisn', $siswa->nisn)],
			'nis' => [Rule::required(), Rule::number(), Rule::max(5), Rule::unique('siswa', 'nis', $siswa->nis)],
			'nama' => [Rule::required(), Rule::max(50)],
			'alamat' => [Rule::required(), Rule::min(4)],
			'telepon' => [Rule::required(), Rule::max(14)],
			'username' => [Rule::required(), Rule::max(25), Rule::unique('pengguna', 'username', $siswa->pengguna->username)],
			'password' => [Rule::max(20)],
			'kelas' => [Rule::required(), Rule::exists('kelas', 'id')],
			'pembayaran' => [Rule::required(), Rule::exists('pembayaran', 'id')],
		])->validate();

		if ($validator->error()) {
			return back()->withError($validator->getErrors());
		}

		$data = $validator->getValidated();
		if (!strlen($data['password'])) {
			unset($data['password']);
		} else {
			$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
		}

		try {
			DB::beginTransaction();

			$dataPengguna = array_intersect_key($data, ['username' => 'username', 'password' => 'password']);

			if (!$siswa->pengguna->update($dataPengguna)) {
				throw new Exception("Failed to update pengguna");
			}

			$dataSiswa = array_diff_key($data, ['username' => 'username', 'password' => 'password']);

			$dataSiswa['kelas_id'] = $dataSiswa['kelas'];
			$dataSiswa['pembayaran_id'] = $dataSiswa['pembayaran'];
			unset($dataSiswa['kelas'], $dataSiswa['pembayaran']);

			if (!$siswa->update($dataSiswa)) {
				throw new Exception("Failed to update siswa");
			}

			DB::commit();

			return back()->with('update-siswa-success', 'Siswa berhasil diperbarui');
		} catch (Exception $ex) {
			DB::rollback();

			return back()->with('update-siswa-failed', 'Siswa gagal diperbarui');
		}
	}

	public function delete(int $id)
	{
		$siswa = (new Siswa)->whereFirst(compact('id'));

		if ($siswa->delete()) {
			return redirect(route('siswa'))->with('delete-siswa-success', 'Siswa berhasil dihapus');
		}

		return back()->with('delete-siswa-failed', 'Siswa gagal dihapus');
	}
}