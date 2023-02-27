<?php

namespace Core\Validation;

class Validator
{
	protected array $data = [];
	protected array $validates = [];
	protected array $rules = [];
	protected array $errors = [];

	public function __construct(array $data, array $rules = [])
	{
		$this->data = $data;
		$this->rules = $rules;
	}

	public function setRules(array $rules = [])
	{
		$this->rules = $rules;

		return $this;
	}

	public static function make(array $data, array $rules = [])
	{
		return new static (...func_get_args());
	}

	public function validate()
	{
		foreach ($this->rules as $key => $rule) {
			$data = $this->data[$key];

			foreach ($rule as $r) {
				if ($r['action']($data)) {
					$this->addValidated($key, $data);
					continue;
				}

				$this->addError($key, ucfirst(sprintf($r['error'], $key)));
				break;
			}
		}

		return $this;
	}

	public function getValidated()
	{
		return $this->validates;
	}

	public function addValidated(string $name, $value)
	{
		$this->validates[$name] = $value;
	}

	public function addError(string $name, string $message)
	{
		$this->errors[$name] = $message;

		return $this;
	}

	public function error()
	{
		return !empty($this->errors);
	}

	public function getErrors()
	{
		return $this->errors;
	}
}