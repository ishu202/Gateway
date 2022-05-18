<?php


namespace App\libraries\Gateway\Factory;


use App\libraries\Gateway\Interfaces\Customer\CustomerFactoryInterface;
use App\libraries\Gateway\Interfaces\Implementation;
use App\libraries\Gateway\StripeCustomer;

class CustomerFactory implements CustomerFactoryInterface
{

	public function createCustomerFactory(array $params): Implementation
	{
		return new StripeCustomer($params);
	}
}
