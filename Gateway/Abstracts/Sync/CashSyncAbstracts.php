<?php


namespace App\libraries\Gateway\Abstracts\Sync;


use CI_Controller;

/**
 * Trait CashSyncAbstracts
 * @package App\libraries\Gateway\Abstracts\Sync
 * @property CI_Controller $CI
 * @property array $arr
 * @method to_array(mixed $response)
 */
trait CashSyncAbstracts
{
	protected function getCashPendingLines()
	{
		$lines_db = $this->CI->Lines->getLines([
			'order_id' => $this->arr['order_id'],
			'type' => 0
		])->response;

		if (count($lines_db)) {
			return $this->to_array($lines_db[0]['response']);
		}

		return $this->to_array('[]');
	}

	protected function getCashInvoice()
	{
		$invoice_db = $this->CI->Order->getOrder([
			'order_id' => $this->arr['order_id']
		], $this->arr['transaction_type']['debit'])->response;

		if (count($this->to_array($invoice_db[0]['response'] ?: '[]'))) {
			return $this->to_array($invoice_db[0]['response']);
		}

		return $this->to_array('[]');
	}

	protected function getCashRefund()
	{
		$refund_db = $this->CI->Order->getRefund([
			'order_id' => $this->arr['order_id']
		], $this->arr['transaction_type']['credit'])->response;

		if (count($this->to_array($refund_db[0]['response'] ?: '[]'))) {
			return $this->to_array($refund_db[0]['response']);
		}
		return $this->to_array('[]');
	}

	protected function getCashFees(bool $fee_data = false)
	{
		$fees_db = $this->CI->Fees->getFees([
			'order_id' => $this->arr['order_id']
		], $this->arr['transaction_type']['fee'])->response;

		if (count($this->to_array($fees_db[0]['response'] ?: '[]'))) {
			if ($fee_data) {
				return $this->to_array($fees_db[0]['table'][0]['fees_data']);
			}
			return $this->to_array($fees_db[0]['response']);
		}
		return $this->to_array('[]');
	}
}
