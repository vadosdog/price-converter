<?php

/**
 * Интерфейс для объектов, которые могут быть элементами в связном списке
 */

namespace App\Interfaces;


interface NodeInterface
{
	/**
	 * @return NodeInterface|null
	 */
	public function next(): ?NodeInterface;

	/**
	 * @param NodeInterface $node
	 * @return void
	 */
	public function setNext(NodeInterface $node);

	public function getValue();
}
