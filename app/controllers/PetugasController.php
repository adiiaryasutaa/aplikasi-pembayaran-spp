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
		if (auth()->guest()) {
			return redirect('login');
		}

		return view('petugas/index', ['petugas' => (new Petugas)->all()])
			->useLayout(new Dashboard());
	}

	public function create()
	{
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

			return back()->with('crete-petugas-success', 'Petugas berhasil ditambahkan');
		} catch (Exception $ex) {
			DB::rollback();

			echo $ex->getMessage();
			exit();

			return back()->with('crete-petugas-failed', 'Petugas gagal ditambahkan');
		}
	}
}