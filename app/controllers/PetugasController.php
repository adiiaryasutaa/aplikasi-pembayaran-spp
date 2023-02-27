<?php

namespace App\Controller;

use App\Model\Pengguna;
use App\Model\Petugas;
use App\View\Layout\Dashboard;
use Core\Auth\Role;
use Core\Foundation\Facade\DB;
use Core\Http\Controller;
use Exception;

class PetugasController extends Controller
{
	public function index()
	{
		// Middleware
		if (auth()->guest()) {
			return redirect('login');
		}

		return view('petugas/index', ['petugas' => (new Petugas)->all()])
			->useLayout(new Dashboard());
	}

	public function create()
	{
		// Middleware
		if (auth()->guest()) {
			return redirect('login');
		}

		[$nama, $username, $password] = $this->request()->only(['nama', 'username', 'password']);

		try {
			DB::beginTransaction();

			$pengguna = new Pengguna();

			if (!$pengguna->insert($username, password_hash($password, PASSWORD_BCRYPT), Role::PETUGAS)) {
				throw new Exception("Failed insert into table pengguna");
			}

			$pengguna->whereFirst('username', $username);

			$petugas = new Petugas();

			if (!$petugas->insert($nama, $pengguna->id)) {
				throw new Exception("Failed insert into petugas");
			}

			DB::commit();

			return back()->with('create-petugas-success', 'Petugas berhasil ditambahkan');
		} catch (Exception $ex) {
			DB::rollback();

			return back()->with('create-petugas-failed', 'Petugas gagal ditambahkan');
		}
	}

	public function show(string $username)
	{
		// Middleware
		if (auth()->guest()) {
			return redirect('login');
		}

		$petugas = new Petugas();
		$petugas->joinWithPetugasWhereFirst(['pengguna.username' => $username, 'pengguna.role' => Role::PETUGAS->value]);

		return $petugas->exists() ? 
				view('petugas/detail')
				->with(compact('petugas'))
				->useLayout(new Dashboard()) :
			"404";
	}

	public function update(string $username)
	{
		$petugas = (new Petugas)->joinWithPetugasWhereFirst(['pengguna.username' => $username]);

		$inputs = [
			'nama' => $this->request('nama'),
			'username' => $this->request('username'),
			'password' => $this->request('password'),
		];

		$updates = [];

		if ($petugas->nama !== $inputs['nama']) {
			$updates['nama'] = $inputs['nama'];
		}

		if ($petugas->pengguna->username !== $inputs['username']) {
			$updates['username'] = $inputs['username'];
		}

		if (
			// check is string empty or blank 
			trim($inputs['password']) !== '' &&
			password_verify($inputs['password'], $petugas->pengguna->password)
		) {
			$updates['password'] = password_hash($inputs['password'], PASSWORD_BCRYPT);
		}

		if (!empty($updates)) {
			if ($petugas->update($updates)) {
				$response = isset($updates['username']) ? 
					redirect(route('petugas.show', ['username' => $updates['username']])) :
					back()->with('update-petugas-success', 'Petugas berhasil diperbarui');

				return $response->with('update-petugas-success', 'Petugas berhasil diperbarui');
			}

			return back()->with('update-petugas-failed', 'Petugas gagal diperbarui');
		}

		return back()->with('update-petugas-canceled', 'Petugas tidak diperbarui, karena data tidak ada yang berubah');
	}

	public function delete(string $username)
	{
		if ((new Petugas)->deleteWhere(['username' => $username])) {
			return redirect(route('petugas'))->with('delete-petugas-success', "Petugas Berhasil dihapus");
		}

		return back()->with('delete-petugas-failed', 'Petugas gagal dihapus');
	}
}