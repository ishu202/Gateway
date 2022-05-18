<?php


namespace App\libraries\Gateway\Abstracts;


use App\libraries\Formatter\Factory\FormatterFactory;
use App\libraries\Formatter\FormatterProvider;
use App\libraries\Gateway\Abstracts\Sync\CashSyncAbstracts;
use App\libraries\Gateway\Abstracts\Sync\ComputedAbstracts;
use App\libraries\Gateway\Abstracts\Sync\StripeSyncAbstracts;

abstract class SyncAbstracts extends GatewayAbstracts
{
	use StripeSyncAbstracts, CashSyncAbstracts, ComputedAbstracts;

	protected function getInvoiceAndLinesData(string $customer_id): array
	{
		if ($this->CashOrStripe($this->arr['customer_id'])) {
			$invoice = $this->getCashInvoice();
			$refund = $this->getCashRefund();
			$computed = $this->get_computed_invoice_response($invoice, $refund);

			return [
				$computed,
				$invoice,
				$this->getCashPendingLines(),
				$refund,
				$this->getCashFees()
			];
		}

		$this->get_invoice_data($customer_id);
//		$this->get_lines_data($customer_id);
		$invoice = $this->get_latest_response('invoice_data');
		$invoice = array_values(array_filter($invoice ?: [], function ($inv) {
			return $inv['metadata']['order_id'] == $this->arr['order_id'];
		}));
		$refund = $this->get_refund_data($invoice);
		$computed = $this->get_computed_invoice_response($invoice ?: [], $refund ?: []);
		$fees = array_values($this->get_fees_data($customer_id, $this->arr['order_id']));

		return [
			$computed,
			$invoice,
			$this->getCashPendingLines(),
			$refund,
			$fees
		];
	}

	protected function format_response($response): array
	{
		$provider = new FormatterProvider();
		$factory = new FormatterFactory();

		return $provider->provideStripeFactory($factory, [
			'stripe_response' => $response
		])->format_stripe_response();
	}

	protected function reduce_lines_from_stripe_invoice($invoice)
	{
		return array_reduce(array_column($invoice, 'lines'), function ($memo, $item) {
			array_push($memo, ...$item['data']);
			return $memo;
		}, []);
	}

	protected function reduce_lines_from_stripe_refund($refunds)
	{
		return array_reduce($refunds, function ($memo, $refund) {
			if (array_keys($refund) === range(0, count($refund) - 1)) {
				array_push($memo, ...$refund);
			} else {
				$memo[] = $refund;
			}

			return $memo;
		}, []);
	}

	protected function reduce_fees_from_response(array $data)
	{
		return array_reduce($data, function ($memo, $fee) {
			$fee_data = json_decode($fee['metadata']['fee_data'], true);
			array_push($memo, ...$this->apply_charge_id_to_fee($fee_data ?: [], $fee['id'] ?: ''));
			//var_dump($memo);
			return $memo;
		}, []);
	}

	protected function apply_charge_id_to_fee(array $data, string $charge_id)
	{
		foreach ($data as $key => $db_fees) {
			$data[$key] += ['payment_id' => $charge_id];
		}
		return $data;
	}

	protected function CashOrStripe($customer_id): bool
	{
		return $this->arr['isCash'];
	}

	protected function to_array(string $data)
	{
		return json_decode($data, true);
	}

}
