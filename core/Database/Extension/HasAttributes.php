<?php

namespace Core\Extension\Database;

trait HasAttributes
{
	protected array $attributes = [];

	protected function setAttributes(array $attributes = [])
	{
		$this->attributes = $attributes;

		return $this;
	}

	protected function setAttribute(string $name, $value)
	{
		$this->attributes[$name] = $value;

		return $this;
	}

	protected function getAttribute(string $name)
	{
		return $this->hasAttribute($name) ? $this->attributes[$name] : null;
	}

	protected function hasAttribute(string $name)
	{
		return isset($this->attributes[$name]);
	}

	protected function resetAttributes()
	{
		$this->attributes = [];
	}
}