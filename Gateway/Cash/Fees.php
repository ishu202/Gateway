<?php


namespace App\libraries\Gateway\Cash;


use App\libraries\Gateway\Abstracts\CashAbstracts;
use App\libraries\Gateway\Interfaces\Implementation;

class Fees extends CashAbstracts implements Implementation
{
	private array $fees_array;

	function create()
	{
		$fees = $this->arr['fees'];
		$payment_id = $this->arr['payment_id'];
		$customer_id = $this->arr['customer_id'];
		$source = $this->arr['source'];
		$type = $this->arr['type'] ?: null;

		$this->fees->set([
			'fees' => $fees,
			'type' => $type,
			'payment_id' => $payment_id,
			'customer_id' => $customer_id,
			'source' => $source
		]);
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
		return json_encode($this->fees->get());
	}
}
