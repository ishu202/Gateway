<?php


namespace App\libraries\Gateway\Providers;


use App\libraries\Gateway\Factory\OrderMetaFactory;
use App\libraries\Gateway\Interfaces\OrderTemplateMeta\OrderMetaInterface;

class OrderMetaProvider
{
	public function provideOrderMetaFactory(OrderMetaFactory $factory, array $params = []): OrderMetaInterface
	{
		return $factory->createOrderTemplateMetaFactory($params);
	}

}
