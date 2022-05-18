<?php


namespace App\libraries\Gateway\Builders;


use App\libraries\Gateway\Abstracts\BuilderAbstracts;
use App\libraries\Gateway\Abstracts\FeesAbstracts;
use JsonSerializable;

class FeesBuilder extends FeesAbstracts implements JsonSerializable
{
	protected function setFeeData(array $fees, ?string $type): FeesBuilder
	{
		$this->data->fee_data = $this->fees_lines_iterator_generator($fees, $type ?: "default");
		return $this;
	}

	protected function setPaymentId($payment_id): FeesBuilder
	{
		$this->data->payment_id = $payment_id;
		return $this;
	}

	protected function setCustomer(string $customer_id): FeesBuilder
	{
		$this->data->customer = $customer_id;
		return $this;
	}

	protected function setSource(string $source): FeesBuilder
	{
		$this->data->source = $source;
		return $this;
	}

	protected function setSubtotal(): FeesBuilder
	{
		$this->data->subtotal = $this->get_sub_total();
		return $this;
	}

	protected function setTax(): FeesBuilder
	{
		$this->data->tax = $this->get_tax();
		return $this;
	}

	protected function setTotal(): FeesBuilder
	{
		$this->data->total = $this->get_total(
			$this->data->tax,
			$this->data->subtotal
		);
		return $this;
	}

	public function get()
	{
		return $this->data;
	}

	public function set(array $params): FeesBuilder
	{
		$this->reset();
//		var_dump($params['fees']);
//		die();
		$this->setFeeData($params['fees'], $params['type'])
			->setPaymentId($params['payment_id'] ?? array_column($params['fees'], 'payment_id'))
			->setCustomer($params['customer_id'])
			->setSource($params['source'])
			->setSubtotal()
			->setTax()
			->setTotal();
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize()
	{
		return (array)$this->data;
	}
}
