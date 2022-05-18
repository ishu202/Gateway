<?php


namespace App\libraries\Gateway\Factory;


use App\libraries\Gateway\Interfaces\OrderTemplateMeta\OrderMetaInterface;
use App\libraries\Gateway\Interfaces\OrderTemplateMeta\OrderTemplateMetaFactoryInterface;
use App\libraries\Gateway\OrderMeta;

class OrderMetaFactory implements OrderTemplateMetaFactoryInterface
{

	public function createOrderTemplateMetaFactory(array $params): OrderMetaInterface
	{
		return new OrderMeta($params);
	}
}
