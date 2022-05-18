<?php


namespace App\libraries\Gateway\Providers;


use App\libraries\Gateway\Factory\CustomerFactory;
use App\libraries\Gateway\Interfaces\Implementation;

class CustomerProvider
{
	public function provideCustomerFactory(CustomerFactory $factory, array $params): Implementation
	{
		return $factory->createCustomerFactory($params);
	}
}
