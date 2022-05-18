<?php


namespace App\libraries\Gateway\Factory;


use App\libraries\Gateway\Interfaces\Invoice\InvoiceFactoryInterface;
use App\libraries\Gateway\Interfaces\Invoice\InvoiceImplementation;
use App\libraries\Gateway\Invoice\Draft;
use App\libraries\Gateway\Invoice\Pay;
use App\libraries\Gateway\Invoice\Refund;

class InvoiceFactory implements InvoiceFactoryInterface
{
	public array $params;

	public function __construct($params = [])
	{
		$this->params = $params;
	}

	function createDraftInvoice($params = []): InvoiceImplementation
	{
		return new Draft($params);
	}

	function payInvoice($params = []): InvoiceImplementation
	{
		return new Pay($params);
	}

	function refundItems($params = []): InvoiceImplementation
	{
		return new Refund($params);
	}

	function refundInvoice($params = []): InvoiceImplementation
	{
		return new Refund($params);
	}
}
