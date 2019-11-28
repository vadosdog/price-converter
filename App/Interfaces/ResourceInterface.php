<?php

/**
 * Интерфейс предназначен для данных, которые могут быть представлены в виде массива
 */

namespace App\Interfaces;


interface ResourceInterface
{
	public function toArray(): array;
}
