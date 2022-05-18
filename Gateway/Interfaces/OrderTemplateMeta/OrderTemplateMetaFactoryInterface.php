<?php


namespace App\libraries\Gateway\Interfaces\OrderTemplateMeta;


interface OrderTemplateMetaFactoryInterface
{
	public function createOrderTemplateMetaFactory(array $params): OrderMetaInterface;
}
