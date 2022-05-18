<?php


namespace App\libraries\Gateway\Invoice;


use App\libraries\Gateway\Abstracts\GatewayAbstracts;
use App\libraries\Gateway\Interfaces\Invoice\InvoiceImplementation;

class Refund extends GatewayAbstracts implements InvoiceImplementation
{

	function create()
	{
		$this->base_request(function () {
			return [
				'refunded' => array_map(function ($val) {
					$tax = (($val['total_amount'] * $this->CI->Rntr->get_tax()[0]['taxpercentage']) / 100);
					$sub_total = $val['total_amount'];
					$refund_amount = (int)number_format(($sub_total + $tax), '2', '', '');

					return $this->stripe->refunds->create([
						'charge' => $val['charge_id'],
						'amount' => $refund_amount,
						'metadata' => $val
					]);
				}, $this->arr['items'])
			];
		});
		if (count($this->get_error())) {
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
		$this->base_request(function () {
			return [
				'all_refund' => array_map(function ($val) {
					return $this->stripe->refunds->all([
						'charge' => $val['charge'],
						'limit' => 100
					])->jsonSerialize()['data'];
				}, $this->arr['invoice'])
			];
		});
	}
}
