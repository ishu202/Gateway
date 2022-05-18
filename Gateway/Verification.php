<?php


namespace App\libraries\Gateway;


use App\libraries\Gateway\Abstracts\GatewayAbstracts;
use App\libraries\Gateway\Interfaces\Implementation;

class Verification extends GatewayAbstracts implements Implementation
{

	/**
	 * @throws \Exception
	 */
	function create()
	{
		$this->base_request(function () {
			return [
				'verification_session' => $this->stripe->identity->verificationSessions->create([
					'type' => 'document',
					'metadata' => [
						'user_id' => $this->arr['customer_token']
					]
				])->jsonSerialize()
			];
		});
		return $this->get_latest_response('verification_session');
	}

	/**
	 * @throws \Exception
	 */
	function update()
	{
		$this->base_request(function () {
			return [
				'update_verification_session' => $this->stripe->identity->verificationSessions->update(
					$this->arr['session'],
					[
						'metadata' => [
							'user_id' => $this->arr['customer_token']
						]
					]
				)
			];
		});
		return $this->get_latest_response('update_verification_session');
	}

	/**
	 * @throws \Exception
	 */
	function delete()
	{
		$this->base_request(function () {
			return [
				'cancel_verification_session' => $this->stripe->identity->verificationSessions->update(
					$this->arr['session'],
					[]
				)
			];
		});
		return $this->get_latest_response('cancel_verification_session');
	}

	/**
	 * @throws \Exception
	 */
	function get()
	{
		$this->base_request(function () {
			return [
				'get_verification_session' => $this->stripe->identity->verificationSessions->update(
					$this->arr['session'],
					[]
				)
			];
		});
		return $this->get_latest_response('get_verification_session');
	}
}
