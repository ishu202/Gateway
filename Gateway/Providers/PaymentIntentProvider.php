<?php

namespace App\libraries\Gateway\Providers;

use App\libraries\Gateway\Factory\PaymentIntentFactory;
use App\libraries\Gateway\Interfaces\Implementation;

class PaymentIntentProvider
{
	public function providePaymentIntent(PaymentIntentFactory $factory, $params): Implementation
	{
		return $factory->createPaymentIntentFactory($params);
	}
}
