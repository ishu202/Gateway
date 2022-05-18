<?php


namespace App\libraries\Gateway\Factory;


use App\libraries\Gateway\Abstracts\GatewayAbstracts;
use App\libraries\Gateway\Interfaces\Implementation;
use App\libraries\Gateway\Interfaces\Source\SourceFactoryInterface;
use App\libraries\Gateway\Source;

class SourceFactory implements SourceFactoryInterface
{
	public function createSourceFactory(array $arr): Implementation
	{
		return new Source($arr);
	}
}
