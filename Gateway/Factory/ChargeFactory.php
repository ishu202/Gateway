<?php


namespace App\libraries\Gateway\Factory;


use App\libraries\Gateway\Charge;
use App\libraries\Gateway\Interfaces\Implementation;

class ChargeFactory
{
	public function createChargeFactory(array $params): Implementation
	{
		return new Charge($params);
	}
}
