<?php


namespace App\libraries\Gateway;


use App\libraries\Gateway\Factory\GatewayFactory;
use App\libraries\Gateway\Factory\SyncFactory;
use App\libraries\Gateway\Interfaces\Delivery\DeliveryFactoryInterface;
use App\libraries\Gateway\Interfaces\Invoice\InvoiceFactoryInterface;
use App\libraries\Gateway\Interfaces\Sync\SyncToStripeInterface;
use App\libraries\Gateway\Interfaces\Tax\TaxFactoryInterface;
use App\libraries\Gateway\Interfaces\Lines\LinesFactoryInterface;

class GatewayProvider
{

	function provideInvoice(GatewayFactory $factory, $params = []): InvoiceFactoryInterface
	{
		return $factory->createInvoiceFactory($params);
	}

	function provideTax(GatewayFactory $factory, $params = []): TaxFactoryInterface
	{
		return $factory->createTaxFactory($params);
	}

	public function provideLines(GatewayFactory $factory, $params = []): LinesFactoryInterface
	{
		return $factory->createLinesFactory($params);
	}

	public function provideSync(GatewayFactory $factory, $params = [])
	{
		return $factory->createSyncFactory($params);
	}

	public function provideVerification(GatewayFactory $factory, $params = [])
	{
		return $factory->createVerification($params);
	}

	public function provideDelivery(GatewayFactory $factory, $params = []): DeliveryFactoryInterface
	{
		return $factory->createDeliveryFactory($params);
	}
}
