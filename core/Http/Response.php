<?php

namespace Core\Http;

use Core\View\View;

class Response
{
	/**
	 * The response content
	 * @var string
	 */
	protected string $content;

	/**
	 * The response status code
	 * @var int
	 */
	protected int $status;

	/**
	 * Response constructor
	 * @param mixed $content
	 * @param mixed $status
	 */
	public function __construct($content = null, $status = 200)
	{
		$this->setContent($content);
		$this->setStatus($status);
	}

	/**
	 * Set response code and show content
	 * @return void
	 */
	public function send()
	{
		http_response_code($this->status);
		echo $this->content;
	}

	/**
	 * Set response content
	 * @param mixed $content
	 * @return Response
	 */
	public function setContent($content)
	{
		if ($content instanceof View) {
			$content = $content->render();
		}

		$this->content = $content;

		return $this;
	}

	/**
	 * Set response status code
	 * @param int $status
	 * @return Response
	 */
	public function setStatus(int $status)
	{
		$this->status = $status;

		return $this;
	}
}