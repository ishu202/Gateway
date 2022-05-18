<?php


namespace App\libraries\Gateway\Interfaces\Customer;


use App\libraries\Gateway\Interfaces\Implementation;

interface CustomerFactoryInterface
{
	public function createCustomerFactory(array $params): Implementation;
}
