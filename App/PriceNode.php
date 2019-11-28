<?php


namespace App;


use App\DateList\Node;
use App\Interfaces\KnowAboutNode;

class PriceNode implements KnowAboutNode
{
	/**
	 * @var Node[]
	 */
	protected $nodes;
	/**
	 * @var Price
	 */
	protected $price;

	public function __construct(Price $price)
	{
		$this->price = $price;
	}

	public function setNode(string $listName, Node $node)
	{
		$this->nodes[$listName] = $node;
	}

	/**
	 * @param string $listName
	 * @return Node|null
	 */
	public function getNode(string $listName)
	{
		return $this->nodes[$listName] ?? null;
	}

	public function getPrice()
	{
		return $this->price;
	}
}
