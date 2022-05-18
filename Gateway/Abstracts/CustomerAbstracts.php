<?php


namespace App\libraries\Gateway\Abstracts;


class CustomerAbstracts extends GatewayAbstracts
{
	protected function get_state_name($state_id): string
	{
		return $this->CI->Rntr->get_state($state_id)[0]->s_full;
	}

	protected function get_city_name($city_id): string
	{
		return $this->CI->Rntr->get_city($city_id)[0]->city;
	}

	protected function get_country_name($country_id): string
	{
		return $this->CI->Rntr->get_country($country_id)[0]->Country;
	}

	/**
	 * @param array $customer_obj
	 * @return bool|array
	 */
	protected function get_delivery(array $customer_obj)
	{
		$shouldAdd = array_filter((array)$customer_obj['shipping']->address, function ($field) {
			return empty($field);
		});
//        var_dump(count($shouldAdd));
//        die();
		//TODO: ask anthony to include store distance and delivery notes and delivery
		// charge in the inputs for accurate validation
		if (count($shouldAdd) <= 3 && count((array)$customer_obj['shipping']->address ?: []) > 1) {
			$delivery = (array) $customer_obj['shipping']->address;
			return array_combine([
				'city', 'country', 'line1', 'line2', 'postal_code', 'state'
			], [
				$this->get_city_name($delivery['city']),
				$this->get_country_name($delivery['country']),
				$delivery['add1'],
				$delivery['add2'],
				$delivery['zip'],
				$this->get_state_name($delivery['state'])
			]);
		}
		return [];
	}

	public function add_delivery($data, $customer, $shipping): array
	{
		if (!empty($shipping)) {
			$data += [
				'shipping' => [
					'address' => $shipping,
					'name' => 'customer shipping address',
					'phone' => $customer['phone']
				]
			];
		}

		return $data;
	}
}
