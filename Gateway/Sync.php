<?php


namespace App\libraries\Gateway;


use App\libraries\Gateway\Abstracts\SyncAbstracts;
use App\libraries\Gateway\Interfaces\Sync\SyncToStripeInterface;
use DateTime;

class Sync extends SyncAbstracts implements SyncToStripeInterface
{

	public function sync_data_from_stripe(): array
	{
		return [
			$this->CI->transaction->update_pending_lines((object)[
				'order_id' => $this->arr['order_id'],
				'response' => json_encode($this->arr['data']['lines']) ?: [],
				'type' => $this->arr['transaction_type']['pending']
			]),
			$this->CI->UpdateOrder->update_init_order(
				$this->format_response($this->arr['data']['lines'])[0],
				$this->arr['order_id']
			),
			$this->CI->Order->createOrder([
				'order_id' => $this->arr['order_id'],
				'db_response' => $this->format_response($this->arr['data']['invoice_computed']),
				'response' => json_encode($this->arr['data']['invoice']),
				'user_id' => $this->arr['user_id'],
				'guest_id' => $this->arr['guest_id'],
				'transaction_type' => $this->arr['transaction_type']['debit'],
				'payment_status' => $this->arr['payment_status']
			]),
			$this->CI->Order->refundOrder([
				'order_id' => $this->arr['order_id'],
				'db_response' => $this->format_response($this->arr['data']['refunds_computed'] ?: []),
				'response' => json_encode($this->arr['data']['refunds']),
				'user_id' => $this->arr['user_id'],
				'guest_id' => $this->arr['guest_id'],
				'transaction_type' => $this->arr['transaction_type']['credit'],
				'payment_status' => $this->arr['payment_status']
			]),
			$this->CI->Order->setOrderStatus([
				'order_id' => $this->arr['order_id'],
				'db_response' => $this->format_response($this->arr['data']['invoice_computed'] ?: []),
				'isCash' => $this->arr['data']['isCash']
			]),
			$this->CI->Fees->createFees([
				'order_id' => $this->arr['order_id'],
				'db_response' => ['fees' => $this->reduce_fees_from_response($this->arr['data']['fees'])],
				'response' => json_encode($this->arr['data']['fees']),
				'user_id' => $this->arr['user_id'],
				'guest_id' => $this->arr['guest_id'],
				'transaction_type' => $this->arr['transaction_type']['fee'],
				'payment_status' => $this->arr['payment_status']
			]),
			$this->CI->OrderMeta->calculateSync([
				'order_id' => $this->arr['order_id'],
				'template_data' => $this->arr['meta_templates']
			])
		];
	}

	public function format_stripe_response(): array
	{

		list($computed, $invoice, $lines, $refunds, $fees) =
			$this->getInvoiceAndLinesData($this->arr['customer_id']);

		$computed_lines = $this->get_computed_lines(
			$this->reduce_lines_from_stripe_invoice($computed)
		);

		$fees = $this->get_computed_fees($fees);
		$computed_refunds = $this->get_computed_refunds($computed_lines);
		$computed_invoice = $this->get_computed_invoice($computed_lines);
		$pending_lines = $this->get_computed_pending_lines($lines);

		return [
			'invoice' => $invoice,
			'invoice_computed' => $computed_invoice,
			'refunds' => $refunds,
			'refunds_computed' => $computed_refunds,
			'lines' => $pending_lines,
			'isCash' => $this->CashOrStripe($this->arr['customer_id']),
			'fees' => $fees
		];
	}

	public function sync(): array
	{
		$this->arr['data'] = $this->format_stripe_response();
		return $this->sync_data_from_stripe();
	}
}
