<?php

namespace App\DateList;

class Node
{
	protected $value;
	protected $next;
	public function __construct($value, Node $next = null)
	{
		$this->value = $value;
		$this->next = $next;
	}

	public function next()
	{
		return $this->next;
	}

	public function setNext(Node $node)
	{
		$this->next = $node;
	}

	public function getValue()
	{
		return $this->value;
	}
}
