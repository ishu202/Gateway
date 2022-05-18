<?php


namespace App\libraries\Gateway\Interfaces\Verification;


use App\libraries\Gateway\Interfaces\Implementation;

interface VerificationFactoryInterface
{
	public function createVerificationFactory(): Implementation;
}
