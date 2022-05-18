<?php


namespace App\libraries\Gateway\Invoice;


use App\libraries\Gateway\Abstracts\GatewayAbstracts;
use App\libraries\Gateway\Interfaces\Invoice\InvoiceImplementation;

class Pay extends GatewayAbstracts implements InvoiceImplementation
{

	function create()
	{
		$this->base_request(function () {
			return [
				'payment' => $this->stripe->invoices->pay(
					$this->arr['invoice']['id'],
					[
						'source' => $this->arr['source'] ?: []
					]
				)
			];
		});

		if (count($this->get_error()) == 0) {
			return true;
		}
		return false;
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
