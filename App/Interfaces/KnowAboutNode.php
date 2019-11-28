<?php

namespace App\Interfaces;

use App\DateList\Node;

interface KnowAboutNode
{
	public function setNode(string $listName, Node $node);

	public function getNode(string $listName);
}
