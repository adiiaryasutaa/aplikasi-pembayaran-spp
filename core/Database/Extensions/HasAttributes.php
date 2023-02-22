<?php

namespace Core\Database\Extension;

trait HasAttributes
{
	protected $attributes = [];

	public function getAttributes(string $name)
	{
		return $this->hasAttributes($name) ? $this->attributes[$name] : null;
	}

	public function hasAttributes(string $name)
	{
		return isset($this->attributes[$name]);
	}
}