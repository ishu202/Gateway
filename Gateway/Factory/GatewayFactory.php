<?php


namespace App\libraries\Gateway\Factory;


use App\libraries\Gateway\Interfaces\Delivery\DeliveryFactoryInterface;
use App\libraries\Gateway\Interfaces\GatewayFactoryInterface;
use App\libraries\Gateway\Interfaces\Invoice\InvoiceFactoryInterface;
use App\libraries\Gateway\Interfaces\Lines\LinesFactoryInterface;
use App\libraries\Gateway\Interfaces\Tax\TaxFactoryInterface;

class GatewayFactory implements GatewayFactoryInterface
{

	function createInvoiceFactory($params = []): InvoiceFactoryInterface
	{
		return new InvoiceFactory($params);
	}

	function createTaxFactory($params): TaxFactoryInterface
	{
		return new TaxFactory($params);
	}

	public function createLinesFactory($params): LinesFactoryInterface
	{
		return new LinesFactory($params);
	}

	public function createSyncFactory($params = [])
	{
		return new SyncFactory($params);
	}

	public function createVerification($params)
	{
		return new VerificationFactory($params);
	}

	public function createDeliveryFactory($params): DeliveryFactoryInterface
	{
		return new DeliveryFactory($params);
	}
}
