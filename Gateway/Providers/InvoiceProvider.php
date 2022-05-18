<?php


namespace App\libraries\Gateway\Providers;


use App\libraries\Gateway\Factory\InvoiceFactory;
use App\libraries\Gateway\Interfaces\Invoice\InvoiceImplementation;

class InvoiceProvider
{
	function provideDraft(InvoiceFactory $factory, array $params = []): InvoiceImplementation
	{
		return $factory->createDraftInvoice($params);
	}

	function providePay(InvoiceFactory $factory, array $params = []): InvoiceImplementation
	{
		return $factory->payInvoice($params);
	}
}
