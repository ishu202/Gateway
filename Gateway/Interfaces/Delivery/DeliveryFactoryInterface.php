<?php


namespace App\libraries\Gateway\Interfaces\Delivery;


use App\libraries\Gateway\Interfaces\Implementation;

interface DeliveryFactoryInterface
{
	public function createDeliveryFactory(array $params): Implementation;
}
