<?php


namespace App\libraries\Gateway\Factory;


use App\libraries\Gateway\Interfaces\Implementation;
use App\libraries\Gateway\Interfaces\Verification\VerificationFactoryInterface;
use App\libraries\Gateway\Verification;

class VerificationFactory implements VerificationFactoryInterface
{
	public array $params;

	public function __construct($params = [])
	{
		$this->params = $params;
	}

	public function createVerificationFactory($params = []): Implementation
	{
		return new Verification($params);
	}

}
