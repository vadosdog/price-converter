<?php

namespace App\DateList;

use App\Interfaces\KnowAboutNode;

class DateList implements \Iterator
{
	/**
	 * @var Node[] $list
	 */
	protected $list = [];
	protected $last = 0;
	protected $iterator = 0;
	protected $listName;

	public function __construct($listName, $list = [])
	{
		$this->listName = $listName;
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

	public function add($value)
	{
		$node = new Node($value);
		$lastNode = $this->list[$this->last] ?? null;
		if ($lastNode) {
			$lastNode->setNext($node);
			$this->last++;
		}
		$this->list[] = $node;

		if ($value instanceof KnowAboutNode) {
			$value->setNode($this->listName, $node);
		}
	}

	public function key()
	{
		$this->iterator;
	}

	public function valid() {
		return isset($this->list[$this->iterator]);
	}
}
