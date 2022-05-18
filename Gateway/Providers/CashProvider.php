<?php


namespace App\libraries\Gateway\Providers;


use App\libraries\Gateway\Factory\CashFactory;
use App\libraries\Gateway\Interfaces\Implementation;

class CashProvider
{
	public function provideCashFactory(CashFactory $factory, array $params = []): array
	{
		return [
			$factory->createInvoiceFactory($params),
			$factory->createLinesFactory($params),
			$factory->createCustomerFactory($params),
			$factory->createRefundFactory($params)
		];
	}

	public function provideFeeFactory(CashFactory $factory, array $params): Implementation
	{
		return $factory->createFeeFactory($params);
	}

	public function provideCashCharge(CashFactory $factory, array $array): Implementation
	{
		return $factory->createChargeFactory($array);
	}
}
