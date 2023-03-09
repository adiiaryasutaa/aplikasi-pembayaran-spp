<?php

namespace App\Controller;

use App\Model\Pengguna;
use App\Model\Petugas;
use App\View\Layout\Dashboard;
use Core\Auth\Role;
use Core\Foundation\Facade\DB;
use Core\Http\Controller;
use Core\Validation\Rule;
use Core\Validation\Validator;
use Exception;

class PetugasController extends Controller
{
	public function index()
	{
		if (auth()->guest()) {
			return redirect('login');
		}

		$petugas = (new Petugas)->all();

		return view('petugas/index')
			->with(compact('petugas'))
			->useLayout(new Dashboard('Petugas'));
	}

	public function create()
	{
		if (auth()->guest()) {
			return redirect('login');
		}

		$inputs = $this->request()->only(['nama', 'username', 'password']);

		$validator = Validator::make($inputs, [
			'nama' => [Rule::required(), Rule::max(50)],
			'username' => [Rule::required(), Rule::max(25), Rule::unique('pengguna', 'username')],
			'password' => [Rule::required(), Rule::max(20)],
		])->validate();

		if ($validator->error()) {
			return back()
				->with(['open-modal' => 1])
				->withError($validator->getErrors());
		}

		$data = array_merge($validator->getValidated(), ['role' => Role::PETUGAS]);
		$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

		try {
			DB::beginTransaction();

			$pengguna = new Pengguna();

			if (!$pengguna->insert(array_diff_key($data, ['nama' => 'nama']))) {
				throw new Exception("Failed insert into table pengguna");
			}

			$pengguna->whereFirst(['username' => $data['username']]);
			$data['pengguna_id'] = $pengguna->id;

			$petugas = new Petugas();

			if (!$petugas->insert(array_intersect_key($data, ['nama' => 'nama', 'pengguna_id' => 'pengguna_id']))) {
				throw new Exception("Failed insert into petugas");
			}

			DB::commit();

			return back()->with('create-petugas-success', 'Petugas berhasil ditambahkan');
		} catch (Exception $ex) {
			DB::rollback();

			return back()->with('create-petugas-failed', 'Petugas gagal ditambahkan');
		}
	}

	public function show(int $id)
	{
		if (auth()->guest()) {
			return redirect('login');
		}

		$petugas = (new Petugas())->getDetailWhere(['petugas.id' => $id, 'pengguna.role' => Role::PETUGAS->value]);

		return $petugas->exists() ?
				view('petugas/detail')
				->with(compact('petugas'))
				->useLayout(new Dashboard("Petugas | $petugas->nama")) :
			"404";
	}

	public function update(int $id)
	{
		$inputs = $this->request()->only(['nama', 'username', 'password']);

		$petugas = (new Petugas)->withPenggunaWhereFirst(['petugas.id' => $id]);

		$validator = Validator::make($inputs, [
			'nama' => [Rule::required(), Rule::max(50)],
			'username' => [Rule::required(), Rule::max(25), Rule::unique('pengguna', 'username', $petugas->pengguna->username)],
			'password' => [Rule::max(20)],
		])->validate();

		if ($validator->error()) {
			return back()
				->with(['open-modal' => 1])
				->withError($validator->getErrors());
		}

		$data = $validator->getValidated();

		if (!strlen($data['password'])) {
			unset($data['password']);
		} else {
			$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
		}

		try {
			DB::beginTransaction();

			if (!$petugas->pengguna->update(array_diff_key($data, ['nama' => 'nama']))) {
				throw new Exception("Update pengguna failed");
			}

			if (!$petugas->update(array_intersect_key($data, ['nama' => 'nama']))) {
				throw new Exception("Update petugas failed");
			}

			DB::commit();

			return back()->with(['update-petugas-success' => 'Petugas berhasil diperbarui']);
		} catch (Exception $ex) {
			DB::rollback();

			return back()->with(['update-petugas-failed' => 'Petugas gagal diperbarui']);
		}
	}

	public function delete(int $id)
	{
		$petugas = (new Petugas)->whereFirst(compact('id'));

		if ($petugas->delete()) {
			return redirect(route('petugas'))->with('delete-petugas-success', "Petugas Berhasil dihapus");
		}

		return back()->with('delete-petugas-failed', 'Petugas gagal dihapus');
	}
}