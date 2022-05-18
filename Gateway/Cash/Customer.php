<?php


namespace App\libraries\Gateway\Cash;


use App\libraries\Gateway\Abstracts\CashAbstracts;
use App\libraries\Gateway\Interfaces\Implementation;

class Customer extends CashAbstracts implements Implementation
{

	function create()
	{
		$this->customer->set($this->arr['customer']);
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
		return json_encode($this->customer->get());
	}
}
