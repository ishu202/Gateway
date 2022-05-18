<?php


namespace App\libraries\Gateway;


use App\libraries\Gateway\Abstracts\TaxAbstracts;
use App\libraries\Gateway\Interfaces\Implementation;

class Tax extends TaxAbstracts implements Implementation
{

	/**
	 * @throws \Exception
	 */
	function create()
	{
		$this->base_request(function () {
			$tax_State = $this->get_state_short_code();
			return [
				'tax_rates' => array_map(function ($state) {
					return $this->stripe->taxRates->create([
						'display_name' => 'TAX',
						'description' => "TAX {$state[0]}",
						'jurisdiction' => $state[0],
						'percentage' => $this->get_tax_percentage()[0]['taxpercentage'],
						'inclusive' => false,
						'state' => "{$state[0]}",
						'country' => 'US'
					]);
				}, $tax_State)
			];
		});
	}

	function update(): array
	{
		return ["implimentation not required at the moment"];
	}

	function delete()
	{
		$this->base_request(function () {
			return [
				'inactive_tax_rates' => array_map(function ($tax) {
					return $this->stripe->taxRates->update(
						$tax->id,
						['active' => false]
					);
				}, $this->get_latest_response('tax_rates'))
			];
		});
	}

	function get()
	{
		return $this->get_latest_response('tax_rates');
	}
}
