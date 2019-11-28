<?php

namespace App\LinkedList;

use App\Interfaces\NodeInterface;

class Node implements NodeInterface
{
	protected $value;
	protected $next;
	public function __construct($value, NodeInterface $next = null)
	{
		$this->value = $value;
		$this->next = $next;
	}

	public function next()
	{
		return $this->next;
	}

	public function setNext(NodeInterface $node)
	{
		$this->next = $node;
	}

	public function getValue()
	{
		return $this->value;
	}
}
