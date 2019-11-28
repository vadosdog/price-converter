<?php

namespace App\LinkedList;

use App\Interfaces\NodeInterface;

class LinkedList implements \Iterator
{
	/**
	 * @var Node[] $list
	 */
	protected $list = [];
	protected $last = 0;
	protected $iterator = 0;

	public function __construct($list = [])
	{
		foreach ($list as $item) {
			$this->add($item);
		}
	}

	public function current()
	{
		return $this->list[$this->iterator] ?? [];
	}

	public function next()
	{
		$this->iterator++;
		return $this->current();
	}

	public function rewind()
	{
		$this->iterator = 0;
	}

	public function add(NodeInterface $node)
	{
		$lastNode = $this->list[$this->last] ?? null;
		if ($lastNode) {
			$lastNode->setNext($node);
			$this->last++;
		}
		$this->list[] = $node;
	}

	public function key()
	{
		$this->iterator;
	}

	public function valid() {
		return isset($this->list[$this->iterator]);
	}
}
