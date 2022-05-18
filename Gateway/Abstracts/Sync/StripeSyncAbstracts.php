<?php


namespace App\libraries\Gateway\Abstracts\Sync;


use App\libraries\Gateway\Abstracts\GatewayAbstracts;
use App\libraries\Gateway\Abstracts\SyncAbstracts;
use App\libraries\Gateway\Invoice\Refund;
use Stripe\StripeClient;

/**
 * @method base_request(\Closure $param)
 * @property StripeClient $stripe
 */
trait StripeSyncAbstracts
{
	protected function get_invoice_data(string $customer_id)
	{
		$this->base_request(function () use ($customer_id) {
			return [
				'invoice_data' => $this->stripe->invoices->all([
					'customer' => $customer_id,
					'status' => 'paid',
					'created' => [
						'gte' => $this->arr['created']
					]
				])->jsonSerialize()['data']
			];
		});
	}

	protected function get_fees_data(string $customer_id, string $order_id): array
	{
		$this->base_request(function () use ($customer_id) {
			return [
				'charges' => $this->stripe->charges->all([
					'customer' => $customer_id
				])->jsonSerialize()['data']
			];
		});
		return array_filter($this->get_latest_response('charges'), function ($charge) use ($order_id) {
			if (
				$charge['invoice'] == null &&
				$charge['status'] == 'succeeded' &&
				$charge['amount'] > 50 &&
				$charge['metadata']['order_id'] == $order_id
			) {
				return true;
			}
			return false;
		});
	}

	protected function get_lines_data(string $customer_id)
	{
		$this->base_request(function () use ($customer_id) {
			return [
				'lines_data' => $this->stripe->invoiceItems->all([
					'customer' => $customer_id
				])->jsonSerialize()['data']
			];
		});
	}

	protected function get_refund_data(array $invoice)
	{
		$refund = new Refund(['invoice' => $invoice]);
		$refund->get();
		return $refund->get_latest_response('all_refund');
	}

}
