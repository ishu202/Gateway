<?php


namespace App\libraries\Gateway\Abstracts\Sync;


use App\libraries\Formatter\Factory\FormatterFactory;
use App\libraries\Formatter\FormatterProvider;

trait ComputedAbstracts
{
	protected function get_computed_lines(array $arr): array
	{
		return array_reduce($arr, function ($memo, &$il) {
			$memo[] = ['metadata' => ($il['metadata'] + ['total_amount' => (string)($il['price']['unit_amount'] / 100)])];
			return $memo;
		}, []);
	}

	protected function get_computed_refunds(array $arr)
	{
		return array_reduce(
			array_filter($arr, function ($line) {
				return (int)$line['metadata']['units'] == 0 || (int)$line['metadata']['total_amount'] == 0;
			}), function ($memo, &$val) {
			$val['metadata']['status'] = "5";
			$val['metadata']['total_amount'] = "0";
			$memo[] = $val;
			return $memo;
		}, []);
	}

	protected function get_computed_pending_lines(array $arr): array
	{
		return array_filter($arr, function ($line) {
			return $line['invoice'] == null;
		});
	}

	protected function get_computed_invoice(array $arr): array
	{
		return array_filter($arr, function ($line) {
			return $line['metadata']['units'] != "0" && $line['metadata']['total_amount'] != "0";
		});
	}

	protected function get_computed_invoice_response(array $invoice, array $refunds): array
	{
		$provider = new FormatterProvider();
		$factory = new FormatterFactory();
		return $provider->providePartialRefundFormatter($factory, [
			'invoice' => $invoice,
			'refunds' => $refunds
		])->re_format();
	}

	protected function get_computed_fees($fees)
	{
		$metas = array_column($fees, 'metadata');
		$paid = array_column($fees, 'paid');
		foreach ($metas as $m_key => &$meta) {
			$fees_arr = json_decode($meta['fee_data'], true);
			foreach ($fees_arr as &$fee) {
				$fee['paid'] = $paid[$m_key];
			}
			$meta['fee_data'] = json_encode($fees_arr);
		}
		$res = [];
		unset($fee);
		foreach ($fees as $f_key => $fee) {
			$res[] = $fee;
			$res[$f_key]['metadata'] = $metas[$f_key];
			$res[$f_key]['refunded'] = !(count(json_decode($metas[$f_key]['fee_data'], true)) > 0);
		}

		return $res;
	}
}
