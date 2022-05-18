<?php

namespace App\libraries\Gateway;

use App\libraries\Gateway\Abstracts\GatewayAbstracts;
use App\libraries\Gateway\Interfaces\Implementation;
use App\libraries\Gateway\Interfaces\PaymentIntent\PaymentIntentInterface;

class PaymentIntent extends GatewayAbstracts implements Implementation
{

	public function update()
	{
		$this->base_request(function () {
			return [
				'payment_intent' => $this->stripe->paymentIntents->update(
					$this->arr['intent'],
					[
						'confirm' => true,
						'payment_method_options' => [
							'card' => [
								'cvc_token' => $this->arr['cvc_token']
							]
						],
					])
			];
		});
	}

	public function create()
	{
		$this->base_request(function () {
			return [
				'payment_intent' => $this->stripe->paymentIntents->create([
					'payment_method_types' => ['card'],
					'payment_method' => $this->arr['source_id'],
					'customer' => $this->arr['customer_id'],
					'amount' => 50,
					'currency' => 'usd'
				])
			];
		});
	}

	public function get()
	{
		$this->base_request(function () {
			return [
				'all_intents' => $this->stripe->paymentIntents->all([
					'customer' => $this->arr['customer_id']
				])->jsonSerialize()
			];
		});

		return $this->get_latest_response('all_intents');
	}

	public function delete()
	{
		$this->base_request(function () {
			return [
				'payment_intents' => $this->stripe->paymentIntents->cancel(
					$this->arr['intent'],
					[
						'cancellation_reason' => $this->arr['reason']
					])
			];
		});
	}
}
