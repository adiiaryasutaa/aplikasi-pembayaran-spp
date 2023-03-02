<?php

namespace App\Model;

use Core\Auth\Role;
use Core\Database\Model;

class Pengguna extends Model
{
	protected string $table = 'pengguna';

	public function __construct(array $attributes = [])
	{
		if (isset($attributes['role']) && !$attributes['role'] instanceof Role) {
			$attributes['role'] = match ($attributes['role']) {
				1 => Role::ADMIN,
				2 => Role::PETUGAS,
				3 => Role::SISWA
			};
		}

		parent::__construct($attributes);
	}

	protected function setAttributes(array $attributes = [])
	{
		if (isset($attributes['role']) && !$attributes['role'] instanceof Role) {
			$attributes['role'] = match ($attributes['role']) {
				1 => Role::ADMIN,
				2 => Role::PETUGAS,
				3 => Role::SISWA
			};
		}

		return parent::setAttributes($attributes);
	}

	public function insert(array $data)
	{
		$data['role'] = $data['role'] instanceof Role ? $data['role']->value : $data['role'];

		return parent::insert($data);
	}

	public function isAdmin()
	{
		return $this->role === Role::ADMIN;
	}

	public function isPetugas()
	{
		return $this->role === Role::PETUGAS;
	}

	public function isSiswa()
	{
		return $this->role === Role::SISWA;
	}
}