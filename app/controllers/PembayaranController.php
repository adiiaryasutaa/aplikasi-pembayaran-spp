<?php

namespace App\Controller;

use App\Model\Pembayaran;
use App\View\Layout\Dashboard;
use Core\Http\Controller;
use Core\Validation\Rule;
use Core\Validation\Validator;

class PembayaranController extends Controller
{
	public function index()
	{
		$pembayaran = (new Pembayaran)->all();

		return view('pembayaran/index')
			->with(compact('pembayaran'))
			->useLayout(new Dashboard);
	}

	public function create()
	{
		$inputs = [
			'tahun-ajaran-1' => $this->request('tahun-ajaran-1'),
			'tahun-ajaran-2' => $this->request('tahun-ajaran-2'),
			'nominal' => $this->request('nominal'),
		];

		$rules = [
			'tahun-ajaran-1' => [Rule::required(), Rule::year()],
			'tahun-ajaran-2' => [Rule::required(), Rule::year()],
			'nominal' => [Rule::required(), Rule::number()],
		];

		$validator = Validator::make($inputs, $rules)->validate();

		if ($validator->error()) {
			return back()->withError($validator->getErrors());
		}

		$data = $validator->getValidated();
		$data['tahun_ajaran'] = $data['tahun-ajaran-1'] . '/' . $data['tahun-ajaran-2'];

		unset($data['tahun-ajaran-1'], $data['tahun-ajaran-2']);

		return ((new Pembayaran)->insert($data)) ? 
			back()->with(['create-pembayaran-success' => 'Pembayaran berhasil dibuat']) :
			back()->withError(['create-pembayaran-failed' => 'Pembayaran gagal dibuat']);
	}

	public function show(int $id)
	{
		$pembayaran = (new Pembayaran)->getDetailWhereFirst(['pembayaran.id' => $id]);

		session()->putInput([
			'tahun-ajaran-1' => explode('/', $pembayaran->tahun_ajaran)[0],
			'tahun-ajaran-2' => explode('/', $pembayaran->tahun_ajaran)[1],
			'nominal' => $pembayaran->nominal
		]);

		return view('pembayaran/detail')
			->with(compact('pembayaran'))
			->useLayout(new Dashboard);
	}

	public function update(int $id)
	{
		$inputs = [
			'tahun-ajaran-1' => $this->request('tahun-ajaran-1'),
			'tahun-ajaran-2' => $this->request('tahun-ajaran-2'),
			'nominal' => $this->request('nominal'),
		];

		$rules = [
			'tahun-ajaran-1' => [Rule::required(), Rule::year()],
			'tahun-ajaran-2' => [Rule::required(), Rule::year()],
			'nominal' => [Rule::required(), Rule::number()],
		];

		$validator = Validator::make($inputs, $rules)->validate();

		if ($validator->error()) {
			return back()->withError($validator->getErrors());
		}

		$pembayaran = (new Pembayaran)->getDetailWhereFirst(['pembayaran.id' => $id]);

		$data = $validator->getValidated();

		$data['tahun_ajaran'] = $data['tahun-ajaran-1'] . '/' . $data['tahun-ajaran-2'];

		unset($data['tahun-ajaran-1'], $data['tahun-ajaran-2']);

		return $pembayaran->update($data) ? 
			back()->with(['update-pembayaran-success' => 'Pembayaran berhasil diperbaharui']) :
			back()->withError(['update-pembayaran-failed' => 'Pembayaran gagal diperbaharui']);
	}

	public function delete(int $id)
	{
		$pembayaran = (new Pembayaran)->getDetailWhereFirst(['pembayaran.id' => $id]);

		return $pembayaran->delete() ? 
			redirect(route('pembayaran'))->with(['delete-pembayaran-success' => 'Pembayaran berhasil dihapus']) :
			back()->withError(['delete-pembayaran-failed' => 'Pembayaran gagal dihapus']);
	}
}