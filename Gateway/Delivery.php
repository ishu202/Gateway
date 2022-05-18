<?php


namespace App\libraries\Gateway;


use App\libraries\Gateway\Abstracts\DeliveryAbstracts;
use App\libraries\Gateway\Abstracts\GatewayAbstracts;
use App\libraries\Gateway\Interfaces\Implementation;
use Ramsey\Uuid\Uuid;

class Delivery extends DeliveryAbstracts implements Implementation
{

	function create()
	{
		$chargable = $this->arr['added'];
		$customer = $this->arr['booking']->getCustomer();
		if ($this->hasDelivery($chargable)) {
			$this->base_request(function () use ($customer) {
				return [
					'delivery' => $this->stripe->invoiceItems->create([
						"amount" => ($customer->shipping->address->delivery_charge * 100),
						"metadata" => (array)$customer->shipping->address,
						"currency" => "usd",
						"customer" => $customer->id,
						"description" => "delivery charge"
					])
				];
			});
		}

		if (count($this->get_error())) {
			return false;
		}
		return true;
	}

	function update()
	{
		// TODO: Implement update() method.
	}

	function delete()
	{
		// TODO: Implement delete() method.
	}

	function get()
	{
		// TODO: Implement get() method.
	}
}
