<?php


namespace App\libraries\Gateway;


use App\libraries\Gateway\Abstracts\CustomerAbstracts;
use App\libraries\Gateway\Interfaces\Implementation;

class StripeCustomer extends CustomerAbstracts implements Implementation
{

	/**
	 * @throws \Exception
	 */
	function create()
	{
		$customer = $this->arr['customer'];
		$this->base_request(function () use ($customer) {
			$city = $this->get_city_name($customer['city']);
			$state = $this->get_state_name($customer['state']);
			$country = $this->get_country_name($customer['country']);
			$shipping = $this->get_delivery($customer);

			$data = [
				"address" => [
					"line1" => $customer['add1'],
					"line2" => $customer['add2'],
					"city" => $city,
					"postal_code" => $customer['zip'],
					"state" => $state,
					"country" => $country
				],
				"description" => ($this->CI->session->logged_in[0]['type_id'] == 2) ? "User" : "Guest",
				"email" => $customer['email'],
				"metadata" => [
					'First Name' => $customer['f_name'],
					'Last Name' => $customer['l_name'],
					'Email' => $customer['email'],
					'Phone' => $customer['phone'],
					'Address Line 1' => $customer['add1'],
					'Address Line 2' => $customer['add2'],
					'Country' => $customer['country'],
					'State' => $customer['state'],
					'Zip' => $customer['zip']
				],
				"name" => "{$customer['f_name']} {$customer['l_name']}",
				"phone" => $customer['phone'],
			];

			$data = $this->add_delivery($data, $customer, $shipping);

			return [
				'new_customer' => $this->stripe->customers->create($data)
			];
		});
		return $this->get_latest_response('new_customer');
	}

	/**
	 * @throws \Exception
	 */
	function update()
	{
		$customer = $this->arr['customer'];
		$this->base_request(function () use ($customer) {
			$city = $this->get_city_name($customer['city']);
			$state = $this->get_state_name($customer['state']);
			$country = $this->get_country_name($customer['country']);
			$shipping = $this->get_delivery($customer);

			$data = [
				"address" => [
					"line1" => $customer['add1'],
					"line2" => trim($customer['add2']),
					"city" => $city,
					"postal_code" => $customer['zip'],
					"state" => $state,
					"country" => $country
				],
				"email" => $customer['email'],
				"metadata" => [
					'First Name' => $customer['f_name'],
					'Last Name' => $customer['l_name'],
					'Email' => $customer['email'],
					'Phone' => $customer['phone'],
					'Address Line 1' => $customer['add1'],
					'Address Line 2' => $customer['add2'],
					'State' => $customer['state'],
					'City' => $city,
					'Country' => $customer['country'],
					'Zip' => $customer['zip']
				],
				"name" => "{$customer['f_name']} {$customer['l_name']}",
				"phone" => $customer['phone']
			];

			$data = $this->add_delivery($data, $customer, $shipping);

			return [
				'updated_customer' => $this->stripe->customers->update(
					$customer['id'],
					$data
				)
			];
		});
	}

	function delete()
	{
		// TODO: Implement delete() method.
	}

	function get()
	{
		$customer = $this->arr['customer'];
		$this->base_request(function () use ($customer) {

			return [
				'customer' => $this->stripe->customers->retrieve(
					$customer['id'],
					[]
				)
			];
		});
		return $this->get_latest_response('customer');
	}
}
