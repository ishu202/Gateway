<?php


namespace App\libraries\Gateway\Abstracts;


abstract class TaxAbstracts extends GatewayAbstracts
{

	protected function get_state_short_code()
	{
		$states = $this->CI->Rntr->fetch_state();
		$contact = $this->CI->Rntr->display_contact_info();
		return array_reduce($states, function ($memo, $state) use ($contact) {
			preg_match("/{$state->State}/", $contact[0]['con_address'], $matches);

			if (count($matches) > 0) {
				$memo[] = $matches;
			}
			return $memo;
		}, []);
	}

	protected function get_tax_percentage()
	{
		return $this->CI->Rntr->get_tax();
	}

}
