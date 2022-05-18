<?php


namespace App\libraries\Gateway\Providers;


use App\libraries\Gateway\Factory\LinesFactory;
use App\libraries\Gateway\Interfaces\Lines\LinesInterface;

class LinesProvider
{
	function provideLinesFactory(LinesFactory $factory, $params = []): LinesInterface
	{

		return $factory->createLinesFactory($params);
	}
}
