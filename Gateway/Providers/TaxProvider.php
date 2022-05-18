<?php


namespace App\libraries\Gateway\Providers;


use App\libraries\Gateway\Factory\InvoiceFactory;
use App\libraries\Gateway\Factory\TaxFactory;
use App\libraries\Gateway\Interfaces\Implementation;

class TaxProvider
{
	function provideTaxFactory(TaxFactory $factory, array $params = []): Implementation
	{
		return $factory->createTaxFactory($params);
	}
}
