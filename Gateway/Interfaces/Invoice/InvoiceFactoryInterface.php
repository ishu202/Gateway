<?php


namespace App\libraries\Gateway\Interfaces\Invoice;


interface InvoiceFactoryInterface
{
	function createDraftInvoice(array $params): InvoiceImplementation;

	function payInvoice(array $params): InvoiceImplementation;

	function refundItems(array $params): InvoiceImplementation;

	function refundInvoice(array $params): InvoiceImplementation;

}
