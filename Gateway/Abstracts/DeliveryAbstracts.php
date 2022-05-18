<?php


namespace App\libraries\Gateway\Abstracts;


abstract class DeliveryAbstracts extends GatewayAbstracts
{
	public function hasDelivery(array $arr): bool
	{
		$chargable = array_column($arr, 'metadata');
		$hasDelivery = false;
		foreach ($chargable as $item) {
			list($delivery) = $this->CI->DeliveryType->get($item['delivery_method']);
			if ((int)$delivery['chargable']) {
				$hasDelivery = true;
			}
		}
		return $hasDelivery;
	}
}
