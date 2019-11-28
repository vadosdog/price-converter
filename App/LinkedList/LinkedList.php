<?php

namespace App\LinkedList;

use App\Interfaces\NodeInterface;

class LinkedList implements \Iterator
{
	/**
	 * @var Node[] $list
	 */
	protected $list = [];

	/**
	 * @var int $last - индекс последнего элемента
	 */
	protected $last = 0;

	/**
	 * @var int $iterator - индекс активного элемента
	 */
	protected $iterator = 0;

	public function __construct($list = [])
	{
		foreach ($list as $item) {
			$this->add($item);
		}
	}

	/**
	 * Получить текущее значение
	 * @return mixed
	 */
	public function current()
	{
		return $this->list[$this->iterator] ?? [];
	}

	/**
	 * Переключить итератор и получить значение
	 * @return mixed
	 */
	public function next()
	{
		$this->iterator++;
		return $this->current();
	}

	/**
	 * Обновить итератор
	 */
	public function rewind()
	{
		$this->iterator = 0;
	}

	/**
	 * Добавить элемент в конец списка
	 * @param NodeInterface $node
	 */
	public function add(NodeInterface $node)
	{
		$lastNode = $this->list[$this->last] ?? null;
		if ($lastNode) {
			$lastNode->setNext($node);
			$this->last++;
		}
		$this->list[] = $node;
	}

	/**
	 * Получить значение итератора
	 *
	 * @return int
	 */
	public function key()
	{
		return $this->iterator;
	}

	/**
	 * Проверить существование значения
	 *
	 * @return bool
	 */
	public function valid() {
		return isset($this->list[$this->iterator]);
	}
}
