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

	/**
	 * @var NodeInterface|null
	 */
	protected $prev
	;
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

	public function prev(): ?NodeInterface
	{
		return $this->prev;
	}

	public function setPrev(NodeInterface $node)
	{
		$this->prev = $node;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function findNext(\Closure $closure): ?NodeInterface
	{
		$current = $this;

		while ($current->next()) {
			$result = $closure($current);
			if ($result) {
				return $current;
			}
		}
		return null;
	}

	public function findPrev(\Closure $closure)
	{
		$current = $this;

		while ($current = $current->prev()) {
			$result = $closure($current->getValue());
			if ($result) {
				return $current->getValue();
			}
		}
		return null;
	}
}
