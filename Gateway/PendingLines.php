<?php


namespace App\libraries\Gateway;


use App\libraries\Gateway\Abstracts\PendingLinesAbstracts;
use App\libraries\Gateway\Interfaces\Lines\LinesInterface;
use Ramsey\Uuid\Uuid;

class PendingLines extends PendingLinesAbstracts implements LinesInterface
{

	function addLines()
	{
		$this->base_request(function () {
			return [
				'line_item' => array_reduce($this->arr['added'], function ($memo, $item) {
					list($id, $uuid, $filtered_tools, $units, $amount, $from, $to, $pick
						, $drop, $status, $delivery_method) = $this->generate_add_item_meta($item);

					$memo[] = $this->stripe->invoiceItems->create([
						"amount" => $amount,
						"metadata" => [
							'uuid' => $uuid ?: Uuid::uuid4()->toString(),
							'id' => $id,
							"name" => $filtered_tools[1],
							"units" => $units,
							"from" => $from,
							"to" => $to,
							"pick_time" => $pick,
							"drop_time" => $drop,
							"status" => $status,
							"delivery_method" => $delivery_method
						],
						"currency" => "usd",
						"customer" => $this->arr['customer_id'],
						"description" => $filtered_tools[1]
					]);
					return $memo;
				}, [])
			];
		});
		if (count($this->get_error())) {
			return false;
		}
		return true;
	}

	function updateLines()
	{
		$this->base_request(function () {
			return [
				'updated_lines' => array_reduce($this->arr['updated'], function ($memo, $item) {
					$this->stripe->invoiceItems->update(
						$item['id'],
						[
							'metadata' => $item['metadata'],
							'amount' => $item['unit_amount']
						]
					);
				}, [])
			];
		});
		if (count($this->get_error())) {
			return false;
		}
		return true;
	}

	function deleteLines()
	{
		$this->base_request(function () {
			return [
				'removed_lines' => array_reduce($this->arr['removed'], function ($memo, $item) {
					$memo[] = $this->stripe->invoiceItems->delete(
						$item['id'],
						[]
					);
					return $memo;
				}, [])
			];
		});
		if (count($this->get_error())) {
			return false;
		}
		return true;
	}

	function getLines()
	{
		$this->base_request(function () {
			return [
				'fresh_lines' => $this->stripe->invoiceItems->all([
					'customer' => $this->arr['customer_id'],
					'pending' => true
				])->jsonSerialize()
			];
		});
		return array_column($this->get_response(), 'fresh_lines')[0]['data'];
	}
}
