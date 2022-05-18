<?php

namespace App\libraries\Gateway\Factory;

use App\libraries\Gateway\Interfaces\Implementation;
use App\libraries\Gateway\Interfaces\PaymentIntent\PaymentIntentFactoryInterface;
use App\libraries\Gateway\Interfaces\PaymentIntent\PaymentIntentInterface;
use App\libraries\Gateway\PaymentIntent;

class PaymentIntentFactory implements PaymentIntentFactoryInterface
{

	public function createPaymentIntentFactory(array $data): Implementation
	{
		return new PaymentIntent($data);
	}
}
