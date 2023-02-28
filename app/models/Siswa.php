<?php

namespace App\Model;

use Core\Auth\Role;
use Core\Database\Model;
use Core\Support\Str;
use PDO;

class Siswa extends Model
{
	protected string $table = 'siswa';

	public function all()
	{
		$query = "SELECT %s FROM %s INNER JOIN %s ON %s";

		$query = sprintf(
			$query,
			"$this->table.*, kelas.nama AS nama_kelas, kelas.kompetensi_keahlian",
			$this->table,
			'kelas',
			"$this->table.kelas_id = kelas.id",
		);

		//dd($query);

		$statement = $this->connection->prepare($query);

		$statement->execute();

		$models = [];

		foreach ($statement->fetchAll(PDO::FETCH_DEFAULT) as $data) {
			$data['kelas'] = new Kelas([
				'id' => $data['kelas_id'],
				'nama' => $data['nama_kelas'],
				'kompetensi_keahlian' => $data['kompetensi_keahlian'],
			]);

			unset($data['kelas_id']);

			$models[] = new static ($data);
		}

		return $models;
	}

	public function where(string|array $columns, $value = null)
	{
		$query = "SELECT * FROM $this->table WHERE ";

		if (is_array($columns)) {
			$value = array_values($columns);
			$columns = array_keys($columns);

			$query .= implode(' AND ', array_map(fn($column) => "$column = :$column", $columns));
		} else {
			$query .= "$columns = :$columns";
		}

		$statement = $this->connection->prepare($query);

		$this->connection->bindValues(
			$statement,
			is_array($columns) ? array_combine($columns, $value) : [$columns => $value]
		);

		$statement->execute();
		$this->hasBeenQueried = true;

		$models = [];
		foreach ($statement->fetchAll(PDO::FETCH_DEFAULT) as $attributes) {
			$models[] = new static ($attributes);
		}

		return $models;
	}

	public function whereFirst(string|array $columns, $value = null)
	{
		$query = "SELECT * FROM $this->table WHERE ";

		if (is_array($columns)) {
			$value = array_values($columns);
			$columns = array_keys($columns);

			$query .= implode(' AND ', array_map(fn($column) => "$column = :$column", $columns));
		} else {
			$query .= "$columns = :$columns";
		}

		$query .= " LIMIT 1";

		$statement = $this->connection->prepare($query);

		$this->connection->bindValues(
			$statement,
			is_array($columns) ? array_combine($columns, $value) : [$columns => $value]
		);

		$statement->execute();
		$this->hasBeenQueried = true;

		$this->attributes = $statement->fetch();

		return $this;
	}

	public function getDetailWhereFirst(array $columns)
	{
		$values = array_values($columns);
		$columns = array_keys($columns);
		$bindingNames = array_combine(
			$columns,
			array_map(fn($column) => ':' . Str::camelCase($column, '.'), $columns)
		);

		$query = sprintf(
			"SELECT %s FROM %s INNER JOIN %s ON %s INNER JOIN %s ON %s INNER JOIN %s ON %s WHERE %s",
			'siswa.*, kelas.nama AS nama_kelas, kelas.kompetensi_keahlian, pengguna.username, pengguna.password, pengguna.role, pembayaran.tahun_ajaran, pembayaran.nominal',
			'siswa',
			'kelas',
			'siswa.kelas_id = kelas.id',
			'pengguna',
			'siswa.pengguna_id = pengguna.id',
			'pembayaran',
			'siswa.pembayaran_id = pembayaran.id',
			implode(array_map(fn($column) => "$column = {$bindingNames[$column]}", $columns))
		);

		$data = $this->connection->result($query, array_combine($bindingNames, $values));
		$this->hasBeenQueried = true;

		$this->attributes = [
			'id' => $data['id'],
			'nisn' => $data['nisn'],
			'nis' => $data['nis'],
			'nama' => $data['nama'],
			'alamat' => $data['alamat'],
			'telepon' => $data['telepon'],
			'kelas' => new Kelas([
				'id' => $data['kelas_id'],
				'nama' => $data['nama_kelas'],
				'kompetensi_keahlian' => $data['kompetensi_keahlian'],
			]),
			'pengguna' => new Pengguna([
				'id' => $data['pengguna_id'],
				'username' => $data['username'],
				'password' => $data['password'],
				'role' => $data['role'],
			]),
			'pembayaran' => new Pembayaran([
				'id' => $data['pembayaran_id'],
				'tahun_ajaran' => $data['tahun_ajaran'],
				'nominal' => $data['nominal'],
			]),
		];

		return $this;
	}

	public function getByPenggunaId(int $id)
	{
		$pengguna = new Pengguna();
		$penggunaTable = $pengguna->getTable();

		$query = "SELECT * FROM $this->table INNER JOIN $penggunaTable ON $this->table.pengguna_id = $penggunaTable.id WHERE $penggunaTable.id = :penggunaId";

		$statement = $this->connection->prepare($query);

		$this->connection->bindValues($statement, ['penggunaId' => $id]);

		$statement->execute();
		$this->hasBeenQueried = true;

		$result = $statement->fetch();

		$pengguna->setAttributes([
			'id' => $result['pengguna_id'],
			'username' => $result['username'],
			'password' => $result['username'],
			'role' => match ($result['role']) {
				1 => Role::ADMIN,
				2 => Role::PETUGAS,
				3 => Role::SISWA,
			}
		]);

		unset($result['pengguna_id'], $result['username'], $result['username'], $result['role']);

		$this->setAttributes(array_merge($result, compact('pengguna')));

		return $this;
	}

	public function insert(array $data)
	{
		$columns = array_keys($data);
		$values = array_values($data);
		$bindingNames = array_map(fn($column) => ":$column", $columns);

		$query = sprintf(
			"INSERT INTO %s (%s) VALUES (%s)",
			$this->table,
			implode(', ', $columns),
			implode(', ', $bindingNames),
		);

		return $this->connection->statement(
			$query,
			array_combine($bindingNames, $values)
		);
	}
}