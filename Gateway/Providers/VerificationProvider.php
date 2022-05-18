<?php


namespace App\libraries\Gateway\Providers;


use App\libraries\Gateway\Factory\VerificationFactory;
use App\libraries\Gateway\Interfaces\Implementation;

class VerificationProvider
{
	public function provideVarificationFactory(VerificationFactory $factory, $params = []): Implementation
	{
		return $factory->createVerificationFactory($params);
	}
}
