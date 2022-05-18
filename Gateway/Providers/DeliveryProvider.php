<?php


namespace App\libraries\Gateway\Providers;


use App\libraries\Gateway\Factory\DeliveryFactory;
use App\libraries\Gateway\Interfaces\Implementation;

class DeliveryProvider
{
	public function provideDeliveryFactory(DeliveryFactory $factory, array $params): Implementation
	{
		return $factory->createDeliveryFactory($params);
	}
}
