<?php

/**
 * Интерфейс предназначен для данных, которые помещаются в качестве value у NodeInterface
 * Обозначает, что значение иметь информацию о NodeInterface в котором он value
 */

namespace App\Interfaces;

interface KnowAboutNode
{
	public function setNode(string $listName, NodeInterface $node);

	public function getNode(string $listName): ?NodeInterface;
}
