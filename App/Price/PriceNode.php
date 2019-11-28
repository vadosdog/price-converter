<?php


namespace App\Price;


use App\Interfaces\KnowAboutNode;
use App\Interfaces\NodeInterface;

class PriceNode implements KnowAboutNode
{
	/**
	 * @var NodeInterface[]
	 */
	protected $nodes;

	/**
	 * @var PriceInput
	 */
	protected $price;

	public function __construct(PriceInput $price)
	{
		$this->price = $price;
	}

	public function setNode(string $listName, NodeInterface $node)
	{
		$this->nodes[$listName] = $node;
	}

	/**
	 * @param string $listName
	 * @return NodeInterface|null
	 */
	public function getNode(string $listName)
	{
		return $this->nodes[$listName] ?? null;
	}

	public function getPrice(): PriceInput
	{
		return $this->price;
	}
}
