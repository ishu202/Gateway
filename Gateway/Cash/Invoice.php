<?php


namespace App\libraries\Gateway\Cash;


use App\libraries\Gateway\Abstracts\CashAbstracts;
use App\libraries\Gateway\Builders\InvoiceBuilder;
use App\libraries\Gateway\Interfaces\Implementation;

class Invoice extends CashAbstracts implements Implementation
{

	function create()
	{
		$this->invoice->set($this->arr['invoice']);
	}

	function update()
	{
		$this->invoice->set($this->arr['invoice_update']);
	}

	function delete()
	{
		$this->invoice = new InvoiceBuilder();
	}

	function get()
	{
		return $this->invoice->get();
	}
}
