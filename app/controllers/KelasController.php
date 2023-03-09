<?php

namespace App\Controller;

use App\Model\Kelas;
use App\View\Layout\Dashboard;
use Core\Http\Controller;
use Core\Validation\Rule;
use Core\Validation\Validator;

class KelasController extends Controller
{
	public function index()
	{
		$kelas = (new Kelas)->all();

		return view('kelas/index')
			->with(compact('kelas'))
			->useLayout(new Dashboard('Kelas'));
	}

	public function show(int $id)
	{
		$kelas = (new Kelas)->whereFirst(['kelas.id' => $id]);

		return view('kelas/detail')
			->with(compact('kelas'))
			->useLayout(new Dashboard("Kelas | $kelas->nama"));
	}

	public function create()
	{
		$data = [
			'nama' => $this->request('nama'),
			'kompetensi_keahlian' => $this->request('kompetensi-keahlian'),
		];

		$validator = Validator::make($data, [
			'nama' => [Rule::required(), Rule::max(10), Rule::unique('kelas', 'nama')],
			'kompetensi_keahlian' => [Rule::required(), Rule::max(50)],
		])->validate();

		if ($validator->error()) {
			return back()
				->with(['open-modal' => 1])
				->withError($validator->getErrors());
		}

		return (new Kelas)->insert($validator->getValidated()) ?
			back()->with('create-kelas-success', 'Kelas berhasil ditambahkan') :
			back()->with('create-kelas-failed', 'Kelas gagal ditambahkan');
	}

	public function update(int $id)
	{
		$data = [
			'nama' => $this->request('nama'),
			'kompetensi_keahlian' => $this->request('kompetensi-keahlian'),
		];

		$kelas = (new Kelas)->whereFirst(['kelas.id' => $id]);

		$validator = Validator::make($data, [
			'nama' => [Rule::required(), Rule::max(10), Rule::unique('kelas', 'nama', $kelas->nama)],
			'kompetensi_keahlian' => [Rule::required(), Rule::max(50)],
		])->validate();

		if ($validator->error()) {
			return back()
				->with(['open-modal' => 1])
				->withError($validator->getErrors());
		}

		return $kelas->update($validator->getValidated()) ?
			back()->with('update-kelas-success', 'Kelas berhasil diperbarui') :
			back()->with('update-kelas-failed', 'Kelas gagal diperbarui');
	}

	public function delete(int $id)
	{
		$kelas = (new Kelas)->whereFirst(['kelas.id' => $id]);

		return $kelas->delete() ?
			redirect(route('kelas'))->with('delete-kelas-success', 'Kelas berhasil dihapus') :
			back()->with('delete-kelas-failed', 'Kelas gagal dihapus');
	}
}