<?php

namespace App\libraries\Gateway\Interfaces\PaymentIntent;

use App\libraries\Gateway\Interfaces\Implementation;

interface PaymentIntentFactoryInterface
{
	public function createPaymentIntentFactory(array $data): Implementation;
}
