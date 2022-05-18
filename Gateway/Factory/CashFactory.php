<?php


namespace App\libraries\Gateway\Factory;


use App\libraries\Gateway\Cash\Charge;
use App\libraries\Gateway\Cash\Customer;
use App\libraries\Gateway\Cash\Fees;
use App\libraries\Gateway\Cash\Invoice;
use App\libraries\Gateway\Cash\Lines;
use App\libraries\Gateway\Cash\Refund;
use App\libraries\Gateway\Interfaces\Cash\CashFactoryInterface;
use App\libraries\Gateway\Interfaces\Implementation;

class CashFactory implements CashFactoryInterface
{

	function createInvoiceFactory(array $params): Implementation
	{
		return new Invoice($params);
	}

	function createLinesFactory(array $params): Implementation
	{
		return new Lines($params);
	}

	function createCustomerFactory(array $params): Implementation
	{
		return new Customer($params);
	}

	function createRefundFactory(array $params): Implementation
	{
		return new Refund($params);
	}

	function createFeeFactory(array $param): Implementation
	{
		return new Fees($param);
	}

	public function createChargeFactory(array $array): Implementation
	{
		return new Charge($array);
	}
}
