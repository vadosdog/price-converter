<?php


namespace App\LinkedList;


use App\Interfaces\KnowAboutNode;

class DateListFactory
{
	public static function build(string $listName, array $list): LinkedList
	{
		$linkedList = new LinkedList();
		foreach ($list as $item) {
			$node = new Node($item);

			$linkedList->add($node);

			if ($item instanceof KnowAboutNode) {
				$item->setNode($listName, $node);
			}
		}
		return $linkedList;
	}
}
