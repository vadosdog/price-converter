<?php

/**
 * Элемент связанного списка
 */

namespace App\LinkedList;

use App\Interfaces\NodeInterface;

class Node implements NodeInterface
{
	protected $value;

	/**
	 * @var NodeInterface|null
	 */
	protected $next;
	public function __construct($value, NodeInterface $next = null)
	{
		$this->value = $value;
		$this->next = $next;
	}

	public function next(): ?NodeInterface
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
