<?php


namespace App\Interfaces;


interface NodeInterface
{
	/**
	 * @return NodeInterface|null
	 */
	public function next();

	/**
	 * @param NodeInterface $node
	 * @return void
	 */
	public function setNext(NodeInterface $node);

	public function getValue();
}
