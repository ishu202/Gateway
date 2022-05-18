<?php


namespace App\libraries\Gateway\Builders;


use App\libraries\Gateway\Abstracts\BuilderAbstracts;
use JsonSerializable;
use stdClass;

class ChargeBuilder extends BuilderAbstracts implements JsonSerializable
{
	protected function reset($object = "charge")
	{
		$prefix = "ch_";
		if ($object == "refund") {
			$prefix = "re_";
		}
		$this->data = new stdClass();
		$this->data->id = $prefix . $this->get_hash();
	}

	protected function setAmount($amount): ChargeBuilder
	{
		$this->data->amount = $amount;
		return $this;
	}

	protected function setCustomer(string $customer): ChargeBuilder
	{
		$this->data->customer = $customer;
		return $this;
	}

	protected function setSource(string $source): ChargeBuilder
	{
		$this->data->source = $source;
		return $this;
	}

	protected function setStatus(int $status = 0): ChargeBuilder
	{
		$this->data->status = $status ? "succeeded" : "pending";
		return $this;
	}

	protected function setPaid(bool $paid = false): ChargeBuilder
	{
		$this->data->paid = $paid;
		return $this;
	}

	protected function setRefunded(): ChargeBuilder
	{
		$fee_data = json_decode($this->data->metadata['fee_data'], true);
		$this->data->refunded = !(count($fee_data) > 0);
		return $this;
	}

	public function get()
	{
		return $this->data;
	}

	public function set(array $params)
	{
		$this->reset($params['object']);
		$this->setAmount($params['amount'])
			->setCustomer($params['customer'])
			->setSource($params['source'])
			->setMetadata($params['metadata'])
			->setStatus()
			->setPaid()
			->setRefunded();
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
