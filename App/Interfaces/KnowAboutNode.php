<?php

namespace App\Interfaces;

interface KnowAboutNode
{
	public function setNode(string $listName, NodeInterface $node);

	public function getNode(string $listName);
}
