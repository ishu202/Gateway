<?php


namespace App\libraries\Gateway\Cash;


use App\libraries\Gateway\Abstracts\CashAbstracts;
use App\libraries\Gateway\Interfaces\Implementation;

class Charge extends CashAbstracts implements Implementation
{

	function create()
	{
		$this->charge->set($this->arr);
	}

	function update()
	{
		$fee_data = json_decode($this->CI->Fees->getFees([
			'order_id' => $this->arr['order_id']
		], 3)->response[0]['response'], true);
		$refund_data = $this->arr['refund_fee'];
		$refunds = $this->arr['refund_fee']['fee_data'];
		$refund_data['amount'] = $refund_data['total'];
		$refund_data['metadata'] = [];
		$refund_data['metadata']['fee_data'] = json_encode($refund_data['fee_data']);

		$res = [];
		foreach ($fee_data as $fee_key => $fee_charge) {
			foreach ($refund_data['payment_id'] as $charge) {
				if ($charge == $fee_charge['id']) {
					$metadata = json_decode($fee_charge['metadata']['fee_data'], true);
					$old_id = array_column($metadata, 'id');
					$ref_id = array_column($refunds, 'id');

					$diff = array_diff($old_id, $ref_id);
					foreach ($metadata as $old_fees) {
						foreach ($diff as $diff_fees_id) {
							if ($old_fees['id'] == $diff_fees_id) {
								$res[] = $old_fees;
							}
						}
					}
					$this->charge->set($refund_data);

					$fee_data[$fee_key] = array_replace_recursive($fee_charge, [
						'metadata' => ['fee_data' => json_encode($res)],
						'refunds' => [
							'data' => array_replace_recursive((array)$this->charge->get(), [
								'status' => 'succeeded',
								'paid' => true,
								'refunded' => true
							])
						]
					]);
				}
			}
		}
		return $fee_data;
	}

	function delete()
	{
		// TODO: Implement delete() method.
	}

	function get()
	{
		return $this->charge->jsonSerialize();
	}
}
