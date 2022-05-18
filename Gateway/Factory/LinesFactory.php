<?php


namespace App\libraries\Gateway\Factory;


use App\libraries\Gateway\Interfaces\Lines\LinesFactoryInterface;
use App\libraries\Gateway\Interfaces\Lines\LinesInterface;
use App\libraries\Gateway\PendingLines;

class LinesFactory implements LinesFactoryInterface
{
	private array $params;

	public function __construct(array $params = [])
	{
		$this->params = $params;
	}

	function createLinesFactory($params = []): LinesInterface
	{
		return new PendingLines($this->params ?: $params);
	}
}
