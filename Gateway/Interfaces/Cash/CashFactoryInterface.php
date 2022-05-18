<?php


namespace App\libraries\Gateway\Interfaces\Cash;


use App\libraries\Gateway\Interfaces\Implementation;

interface CashFactoryInterface
{
	function createInvoiceFactory(array $params): Implementation;

	function createLinesFactory(array $params): Implementation;

	function createCustomerFactory(array $params): Implementation;

	function createRefundFactory(array $params): Implementation;

	function createFeeFactory(array $param): Implementation;
}
