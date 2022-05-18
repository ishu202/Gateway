<?php


namespace App\libraries\Gateway\Factory;


use App\libraries\Gateway\Interfaces\Implementation;
use App\libraries\Gateway\Interfaces\Tax\TaxFactoryInterface;
use App\libraries\Gateway\Tax;

class TaxFactory implements TaxFactoryInterface
{
	public array $params;

	public function __construct($params = [])
	{
		$this->params = $params;
	}

	function createTaxFactory($params = []): Implementation
	{
		return new Tax($params);
	}
}
