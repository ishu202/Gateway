<?php


namespace App\libraries\Gateway\Factory;


use App\libraries\Gateway\Abstracts\GatewayAbstracts;
use App\libraries\Gateway\Delivery;
use App\libraries\Gateway\Interfaces\Delivery\DeliveryFactoryInterface;
use App\libraries\Gateway\Interfaces\Implementation;

class DeliveryFactory implements DeliveryFactoryInterface
{
	public array $params;

	public function __construct($params = [])
	{
		$this->params = $params;
	}

	public function createDeliveryFactory($params = []): Implementation
	{
		return new Delivery($this->params ?: $params);
	}
}
