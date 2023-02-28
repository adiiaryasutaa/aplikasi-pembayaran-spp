<?php

namespace App\Controller;

use App\Model\Kelas;
use App\Model\Pengguna;
use App\Model\Siswa;
use App\View\Layout\Dashboard;
use Core\Auth\Role;
use Core\Foundation\Facade\DB;
use Core\Http\Controller;
use Core\Validation\Rules;
use Core\Validation\Validator;
use Exception;

class SiswaController extends Controller
{
	public function index()
	{
		$siswa = (new Siswa)->all();
		$kelas = (new Kelas)->all();

		return view('siswa/index')
			->with(compact('siswa', 'kelas'))
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
		];

		$rules = [
			'nisn' => [Rules::required(), Rules::number(), Rules::max(10), Rules::unique('siswa', 'nisn')],
			'nis' => [Rules::required(), Rules::number(), Rules::max(5), Rules::unique('siswa', 'nisn')],
			'nama' => [Rules::required(), Rules::max(50)],
			'alamat' => [Rules::min(4)],
			'telepon' => [Rules::max(14)],
			'username' => [Rules::required(), Rules::max(25), Rules::unique('pengguna', 'username')],
			'password' => [Rules::required(), Rules::min(6), Rules::max(20)],
		];

		$validator = Validator::make($inputs, $rules)->validate();

		if ($validator->error()) {
			return back()
				->withError($validator->getErrors())
				->with('continue', 1);
		}

		$validated = $validator->getValidated();

		try {
			DB::beginTransaction();

			$pengguna = (new Pengguna);
			$pengguna->insert($validated['username'], $validated['password'], Role::SISWA);
			$pengguna->whereFirst(['username' => $validated['username']]);

			$siswa = (new Siswa)->insert(
				array_merge(
					array_diff_key($validated, ['username', 'password']),
					['pengguna_id' => $pengguna->id]
				)
			);

			if (!$siswa) {
				throw new Exception();
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

		return view('siswa/detail')
			->with(compact('siswa'))
			->useLayout(new Dashboard);
	}

	public function update()
	{
		# code...
	}

	public function delete()
	{
		# code...
	}
}