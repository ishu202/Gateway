<?php


namespace App\libraries\Gateway\Invoice;


use App\libraries\Gateway\Abstracts\GatewayAbstracts;
use App\libraries\Gateway\Interfaces\Invoice\InvoiceImplementation;

class Draft extends GatewayAbstracts implements InvoiceImplementation
{

	function create()
	{
		$this->base_request(function () {
			return [
				'invoice' => $this->stripe->invoices->create([
					'customer' => $this->arr['customer_id'],
					'metadata' => [
						'order_id' => $this->arr['order_id']
					],
					'default_tax_rates' => $this->arr['tax_rates']
				])
			];
		});
	}

	function update()
	{
		// TODO: Implement update() method.
	}

	//void the invoice
	function delete()
	{
		$this->base_request(function () {
			return [
				'void_invoice' => $this->stripe->invoices->voidInvoice(
					$this->arr['invoice']['id'],
					[
						'source' => $this->arr['source'] ?: []
					]
				)
			];
		});
		if (count($this->get_error())) {
			return false;
		}
		return true;
	}

	function get()
	{
		return $this->get_latest_response('invoice')->jsonSerialize();
	}
}
