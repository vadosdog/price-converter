<?php

/**
 * Вспомогательная фабрика, создающая связные списки
 */

namespace App\LinkedList;


use App\Interfaces\KnowAboutNode;

class DateListFactory
{
	/**
	 * @param string $listName
	 * @param array $list
	 * @return LinkedList
	 */
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
