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
		// Middleware
		if (auth()->guest()) {
			return redirect('login');
		}

		$petugas = (new Petugas)->all();

		return view('petugas/index')
			->with(compact('petugas'))
			->useLayout(new Dashboard());
	}

	public function create()
	{
		// Middleware
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
			return back()->withError($validator->getErrors());
		}

		$data = $validator->getValidated();
		$data['role'] = Role::PETUGAS;

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

			dd($ex);

			return back()->with('create-petugas-failed', 'Petugas gagal ditambahkan');
		}
	}

	public function show(string $username)
	{
		// Middleware
		if (auth()->guest()) {
			return redirect('login');
		}

		$petugas = (new Petugas())->getDetailWhere(
			['pengguna.username' => $username, 'pengguna.role' => Role::PETUGAS->value]
		);

		return $petugas->exists() ? 
				view('petugas/detail')
				->with(compact('petugas'))
				->useLayout(new Dashboard()) :
			"404";
	}

	public function update(string $username)
	{
		$inputs = $this->request()->only(['nama', 'username', 'password']);

		$validator = Validator::make($inputs, [
			'nama' => [Rule::required(), Rule::max(50)],
			'username' => [Rule::required(), Rule::max(25), Rule::unique('pengguna', 'username', $inputs['username'])],
			'password' => [Rule::max(20)],
		])->validate();

		if ($validator->error()) {
			return back()->withError($validator->getErrors());
		}

		$data = $validator->getValidated();

		if (!strlen($data['password'])) {
			unset($data['password']);
		}

		$petugas = (new Petugas)->getDetailWhere(['pengguna.username' => $username]);

		try {
			DB::beginTransaction();

			if (!$petugas->pengguna->update(array_diff_key($data, ['nama' => 'nama']))) {
				throw new Exception("Update pengguna failed");
			}

			if (!$petugas->update(array_intersect_key($data, ['nama' => 'nama']))) {
				throw new Exception("Update petugas failed");
			}

			DB::commit();

			return redirect(route('petugas.show', ['username' => $data['username']]))
				->with(['update-petugas-success' => 'Petugas berhasil diperbarui']);
		} catch (Exception $ex) {
			DB::rollback();

			return back()->with(['update-petugas-failed' => 'Petugas gagal diperbarui']);
		}
	}

	public function delete(string $username)
	{
		$petugas = (new Petugas)->getDetailWhere(compact('username'));

		if ($petugas->delete()) {
			return redirect(route('petugas'))->with('delete-petugas-success', "Petugas Berhasil dihapus");
		}

		return back()->with('delete-petugas-failed', 'Petugas gagal dihapus');
	}
}