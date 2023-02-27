<?php

namespace App\Controller;

use App\Model\Kelas;
use App\View\Layout\Dashboard;
use Core\Http\Controller;

class KelasController extends Controller
{
	public function index()
	{
		$kelas = (new Kelas)->all();

		return view('kelas/index')
			->with(compact('kelas'))
			->useLayout(new Dashboard);
	}

	public function show(int $id)
	{
		$kelas = (new Kelas)->whereFirst(['kelas.id' => $id]);

		return view('kelas/detail')
			->with(compact('kelas'))
			->useLayout(new Dashboard);
	}

	public function create()
	{
		$nama = $this->request('nama');
		$kompetensiKeahlian = $this->request('kompetensi-keahlian');

		if (trim($nama) === '') {

		}

		if (trim($kompetensiKeahlian) === '') {

		}

		return (new Kelas)->insert($nama, $kompetensiKeahlian) ? 
			back()->with('create-kelas-success', 'Kelas berhasil ditambahkan') :
			back()->with('create-kelas-failed', 'Kelas gagal ditambahkan');
	}

	public function update(int $id)
	{
		$inputs = [
			'nama' => $this->request('nama'),
			'kompetensi_keahlian' => $this->request('kompetensi-keahlian'),
		];

		$kelas = (new Kelas)->whereFirst(['kelas.id' => $id]);

		if (trim($inputs['nama']) === '' || $inputs['nama'] === $kelas->nama) {
			unset($inputs['nama']);
		}

		if (trim($inputs['kompetensi_keahlian']) === '' || $inputs['kompetensi_keahlian'] === $kelas->kompetensi_keahlian) {
			unset($inputs['kompetensi_keahlian']);
		}

		if (!empty($inputs)) {
			return $kelas->update($inputs) ? 
				back()->with('update-kelas-success', 'Kelas berhasil diperbarui') :
				back()->with('update-kelas-failed', 'Kelas gagal diperbarui');
		}
		return back()->with('update-kelas-canceled', 'Petugas tidak diperbarui, karena data tidak ada yang berubah atau semua input kosong');
	}

	public function delete(int $id)
	{
		# code...
	}
}