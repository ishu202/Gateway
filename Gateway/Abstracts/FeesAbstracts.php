<?php


namespace App\libraries\Gateway\Abstracts;


use App\libraries\Gateway\Builders\FeesBuilder;
use Generator;

abstract class FeesAbstracts extends BuilderAbstracts
{
	protected \stdClass $data;

	protected function reset($object = 'fees_data')
	{
		$this->data = new \stdClass();
		$this->data->id = 'fee_' . $this->get_hash();
		$this->data->object = $object;
	}

	protected function setFeeId(?string $fees_id, $type): FeesAbstracts
	{
		$this->data->fees_id = $fees_id;
		return $this;
	}

	protected function setFeesName(string $name): FeesAbstracts
	{
		$this->data->name = $name;
		return $this;
	}

	protected function setFeesAmount(string $amount, $type): FeesAbstracts
	{
		if ($type == "refund") {
			$this->data->amount = $this->format_unit_amount($amount);
		} else {
			$this->data->amount = $this->format_unit_amount($amount * 100);
		}
		return $this;
	}

	protected function setFeesDesc(string $desc): FeesAbstracts
	{
		$this->data->desc = $desc;
		return $this;
	}

	protected function setFeesTypeId(string $fee_type_id): FeesAbstracts
	{
		$this->data->fee_type_id = $fee_type_id;
		return $this;
	}

	protected function get_sub_total()
	{
		$res = 0;
		foreach ($this->data->fee_data as $fee) {
			$res += $this->format_unit_amount($fee['amount']);
		}
		return $res;
	}

	protected function get_tax()
	{
		$res = 0;
		$CI = &get_instance();
		$tax = $CI->Rntr->get_tax()[0]['taxpercentage'];

		foreach ($this->data->fee_data as $key => $fee) {
			if ($fee['fee_type_id'] == 3) {
				$tax_amount = $this->format_unit_amount((($fee['amount'] * $tax) / 100));
				$res += $tax_amount;
				$this->data->fee_data[$key]['tax'] = $tax_amount;
			}
		}
		return $res;
	}

	protected function get_total($tax, $total)
	{
		return $this->format_unit_amount($total + $tax);
	}

	protected function setFeesInvoice(?string $invoice)
	{
		$this->data->invoice = $invoice;
		return $this;
	}


	protected function setPaid(bool $status): FeesAbstracts
	{
		$this->data->paid = $status;
		return $this;
	}

	protected function fees_lines_iterator_generator($fees, $type = "default")
	{
		return array_reduce($fees, function ($memo, $val) use ($type) {
			$keys = $this->get_keys($type);

			foreach ($this->get_generator($val, $type) as $line) {
				$data = array_combine($keys, $line);

				$this->setId($data['id'], $type)
					->setFeeId($data['fees_id'], $type)
					->setFeesName($data['name'])
					->setFeesAmount($data['amount'], $type)
					->setFeesDesc($data['desc'])
					->setFeesTypeId($data['type_id'])
					->setPaid($data['paid'] ?: false)
					->setFeesInvoice($data['invoice']);
				$memo[] = (array)$this->data;
			}
			$this->reset($type);
			return $memo;
		}, []);
	}

	protected function fees_lines_generator(array $arr): Generator
	{
		yield ([
			"id" => "fee_" . $this->get_hash(),
			"fees_id" => $arr['id'],
			"name" => $arr['name'],
			"amount" => $arr['amount'],
			"desc" => $arr['desc'],
			"type_id" => $arr['type_id'],
			"invoice" => $arr['invoice']
		]);
	}

	protected function fees_refund_generator(array $arr): Generator
	{
		yield ([
			"id" => $arr['id'],
			"fees_id" => $arr['fee_id'],
			"name" => $arr['name'],
			"amount" => $arr['amount'],
			"desc" => $arr['desc'],
			"type_id" => $arr['type_id'],
			"paid" => $arr['paid'] ?: true,
			"invoice" => $arr['invoice']
		]);
	}

	protected function get_generator($val, $type): Generator
	{
		if ($type == "refund") {
			return $this->fees_refund_generator($val);
		}
		return $this->fees_lines_generator($val);
	}

	protected function get_keys($type)
	{
		if ($type == "refund") {
			return [
				'id', 'fees_id', 'name', 'amount',
				'desc', 'type_id', 'paid', 'invoice'
			];
		}

		return [
			'id', 'fees_id', 'name', 'amount',
			'desc', 'type_id', 'invoice'
		];
	}

	private function setId($id, $type): FeesAbstracts
	{
		if ($type == "refund") {
			$this->data->id = $id;
		}
		return $this;
	}

}
