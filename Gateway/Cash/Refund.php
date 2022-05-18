<?php


namespace App\libraries\Gateway\Cash;


use App\libraries\Gateway\Abstracts\CashAbstracts;
use App\libraries\Gateway\Interfaces\Implementation;

class Refund extends CashAbstracts implements Implementation
{
	private array $refund_arr;

	function create()
	{
		$this->refund_arr = $this->refund->refund_iterator_generator($this->arr['refund'], $this->refund);
	}

	function update()
	{
		return ["implementation not required at the moment."];
	}

	function delete()
	{
		return ["implementation not required"];
	}

	function get()
	{
		return json_encode($this->refund_arr);
	}
}
