<?php


namespace App\libraries\Gateway\Abstracts;


use App\libraries\Dashboard\Utility;
use DateTime;
use Exception;
use Generator;

abstract class PendingLinesAbstracts extends GatewayAbstracts
{
	protected function get_tool_name($item)
	{
		return Utility::array_flatten(array_filter(
			array_map(function ($item_info) use ($item) {

				preg_match("/^{$item_info->id}$/", $item['id'], $matches);
				if (count($matches)) {
					$matches[] = $item_info->t_name;
				} else {
					preg_match("/^{$item_info->id}$/", $item['tool_id'], $matches);
					if (count($matches)) {
						$matches[] = $item_info->t_name;
					}
				}
				return $matches;
			}, $this->CI->Rntr->get_rentable_tool()),
			function ($val) {
				return count($val) > 0;
			}));
	}

	/**
	 * @throws Exception
	 */
	protected function generate_add_item_meta($item): array
	{
		$amount = $item[6] * 100 ?: $item[0] * 100 ?: $item['total_amount'] * 100 ?: $item['unit_amount'] ?: $item['amount'];
		$uuid = $item['uuid'] ?: null;
		$item = $this->isStripeResponse($item);
		$pick_val = $item[4] ?: $item['pick_time'];
		$drop_val = $item[5] ?: $item['drop_time'];
		$from_val = $item[1] ?: $item['date_from'] ?: $item['from'];
		$to_val = $item[2] ?: $item['date_to'] ?: $item['to'];
		$delivery_method = $item[7] ?: $item['delivery_method'] ?: 1;

		return [
			$item['id'],
			$uuid,
			$this->get_tool_name($item),
			$item[3] ?: $item['units'] ?: null,
			$amount,
			(new DateTime($from_val))->format("m/d/Y"),
			(new DateTime($to_val))->format("m/d/Y"),
			(new DateTime(preg_replace("/[APM]+$/", "", $pick_val)))->format("g:ia") ?: null,
			(new DateTime(preg_replace("/[APM]+$/", "", $drop_val)))->format("g:ia") ?: null,
			$item['status'] ?: 0,
			$delivery_method
		];
	}

	protected function isStripeResponse($item): array
	{
		if (is_array($item['metadata'])) {
			return $item['metadata'];
		}
		return $item;
	}

}
