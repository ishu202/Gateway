<?php


namespace App\libraries\Gateway\Abstracts;


use CI_Controller;
use Closure;
use Exception;
use Ramsey\Uuid\Uuid;
use Stripe\Exception\ApiConnectionException;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\AuthenticationException;
use Stripe\Exception\CardException;
use Stripe\Exception\InvalidRequestException;
use Stripe\Exception\RateLimitException;
use Stripe\StripeClient;

abstract class GatewayAbstracts
{
	protected StripeClient $stripe;
	protected array $error = [];
	protected array $success = [];
	protected array $response = [];
	protected array $arr;
	protected CI_Controller $CI;

	public function __construct(array $arr)
	{
		$this->stripe = new StripeClient(env('STRIPESECRET'));
		$this->CI = &get_instance();
		$this->arr = $arr;
	}

	/**
	 * @return array
	 */
	public function get_response(): array
	{
		return $this->response;
	}

	/**
	 * @param array $response
	 */
	public function set_response(array $response)
	{
		$this->response[] = $response;
	}

	/**
	 * @return array
	 */
	public function get_error()
	{
		return $this->error;
	}

	/**
	 * @param mixed $error
	 */
	public function set_error($error)
	{
		$this->error[] = $error;
	}

	/**
	 * @return array
	 */
	public function get_success()
	{
		return $this->success;
	}

	/**
	 * @param mixed $success
	 */
	public function set_success($success)
	{
		$this->success[] = $success;
	}

	/**
	 * @param Closure $function
	 *
	 * @return array|mixed
	 */
	protected function base_request(Closure $function)
	{

		try {
			$this->set_response($function());
			$this->set_success(["success"]);
		} catch (CardException $e) {
			$this->set_error("{$e->getError()->message}");
		} catch (
		RateLimitException|
		Exception|
		InvalidRequestException|
		AuthenticationException|
		ApiConnectionException|
		ApiErrorException $e) {
			$this->set_error($e->getMessage());
		}

		if (count($this->error)) {
//			var_dump($this->get_error());
//			die();
			if (count($this->CI->session->flashdata('message') ?: [])) {
				$this->CI->session->set_flashdata('message',
					array_merge($this->CI->session->flashdata('message'), [['error' => $this->get_error()]])
				);
			} else {
				$this->CI->session->set_flashdata('message', [['error' => $this->get_error()]]);
			}

			return $this->get_error();
		} else {
			return $this->get_success();
		}
	}

	public function get_latest_response(string $key)
	{
		$tax_rates_array = array_column($this->response, $key);
		$keys = array_keys($tax_rates_array) ?: [];
		$index = (count($keys) > 0) ? max(array_keys($tax_rates_array)) : 0;
		return $tax_rates_array[$index];
	}
}
