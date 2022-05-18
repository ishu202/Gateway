<?php


namespace App\libraries\Gateway;


use App\libraries\Gateway\Abstracts\GatewayAbstracts;
use App\libraries\Gateway\Interfaces\Implementation;

class Charge extends GatewayAbstracts implements Implementation
{

	function create()
	{
		$data = $this->arr['data'];
		$this->base_request(function () use ($data) {
			return [
				'charge' => $this->stripe->charges->create([
					'amount' => $data['amount'],
					'customer' => $data['customer'],
					'source' => $data['source'],
					'currency' => 'usd',
					'metadata' => $data['metadata'] + ['order_id' => $this->arr['order_id']]
				])
			];
		});
	}

	function update()
	{
		$data = $this->arr['update'];

		$this->base_request(function () use ($data) {
			return array_reduce($data, function ($memo, $charge) {
				$memo[] = $this->stripe->charges->update(
					$charge['id'],
					[
						'metadata' => $charge['metadata'] + ['order_id' => $this->arr['order_id']]
					]);
				return $memo;
			}, []);
		});
	}

	function delete()
	{
		$refunds = $this->arr['refund'];
		$this->base_request(function () use ($refunds) {
			return array_reduce($refunds, function ($memo, $refund) {
				$memo[] = $this->stripe->refunds->create([
					'charge' => $refund['payment_id'],
					'amount' => ($refund['amount'] + $refund['tax'] ?: 0),
					'metadata' => [
						'fee_data' => json_encode($refund)
					]
				]);
				return $memo;
			}, []);
		});
	}

	function get()
	{
		$this->get_latest_response('charge');
	}
}
