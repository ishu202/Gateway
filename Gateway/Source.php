<?php


namespace App\libraries\Gateway;


use App\libraries\Gateway\Abstracts\GatewayAbstracts;
use App\libraries\Gateway\Interfaces\Implementation;

class Source extends GatewayAbstracts implements Implementation
{

	function create()
	{
		$customerid = $this->arr['customer_id'];
		$source = $this->arr['source_id'];
		return $this->base_request(function () use ($customerid, $source) {
			return [
				'card' => $this->stripe->customers->createSource(
					$customerid,
					[
						'source' => $source
					]
				)
			];
		});
	}

	function update()
	{
		// TODO: Implement update() method.
	}

	function delete()
	{
		$customerid = $this->arr['customer_id'];
		$cardid = $this->arr['card_id'];
		$this->base_request(function () use ($customerid, $cardid) {
			return [
				'deleted_card' => $this->stripe->customers->deleteSource($customerid, $cardid)
			];
		});
	}

	function get()
	{
		$customerid = $this->arr['customer_id'];
		$this->base_request(function () use ($customerid) {
			return [
				"attached_sources" => $this->stripe->customers->allSources(
					$customerid,
					[
						'limit' => 100
					]
				)->jsonSerialize()
			];
		});

		return $this->get_latest_response('attached_sources');
	}
}
