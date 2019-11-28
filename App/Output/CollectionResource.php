<?php

namespace App\Output;

use App\Interfaces\ResourceInterface;

class CollectionResource implements ResourceInterface
{
	/**
	 * @var ResourceInterface[]
	 */
	protected $resource = [];

	/**
	 * CollectionResource constructor.
	 * @param ResourceInterface[] $array
	 */
	public function __construct(array $array = [])
	{
		foreach ($array as $item) {
			$this->add($item);
		}
	}

	public function add(ResourceInterface $value)
	{
		$this->resource[] = $value;
	}

	public function toArray(): array
	{
		return array_map(function (ResourceInterface $item) {
			return $item->toArray();
		}, $this->resource);
	}
}
