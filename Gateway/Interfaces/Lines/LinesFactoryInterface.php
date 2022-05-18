<?php


namespace App\libraries\Gateway\Interfaces\Lines;


interface LinesFactoryInterface
{
	function createLinesFactory(array $params): LinesInterface;
}
