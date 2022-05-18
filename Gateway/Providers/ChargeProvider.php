<?php


namespace App\libraries\Gateway\Providers;


use App\libraries\Gateway\Factory\ChargeFactory;
use App\libraries\Gateway\Interfaces\Implementation;

class ChargeProvider
{
	public function provideChargeFactory(ChargeFactory $factory, array $params): Implementation
	{
		return $factory->createChargeFactory($params);
	}
}
