<?php


namespace App\libraries\Gateway\Builders;


use App\libraries\Gateway\Abstracts\BuilderAbstracts;
use stdClass;

class RefundBuilder extends BuilderAbstracts implements \JsonSerializable
{

	protected function reset()
	{
		$this->data = new stdClass();
		$this->data->id = 're_' . $this->get_hash();
		$this->data->object = 'refund';
	}

	protected function setAmount($amount): RefundBuilder
	{
		$CI = &get_instance();
		$tax = $CI->Rntr->get_tax()[0]['taxpercentage'];
		$this->data->amount = $this->format_unit_amount(($amount + ($amount * $tax) / 100));
		return $this;
	}

	protected function setReason(string $reason): RefundBuilder
	{
		$this->data->reason = $reason;
		return $this;
	}

	protected function setCharge(string $charge): RefundBuilder
	{
		$this->data->charge = $charge;
		return $this;
	}

	protected function setStatus(string $status): RefundBuilder
	{
		$this->data->status = $status;
		return $this;
	}

	protected function setCreatedAt()
	{
		$this->data->created = $this->get_created_at();
	}

	public function get()
	{
		return json_encode($this->data);
	}

	public function set(array $params)
	{
		$this->reset();
		$this->setAmount($params['amount'])
			->setCharge($params['charge'])
			->setMetadata($params['metadata'])
			->setReason($params['reason'] ?: "")
			->setStatus($params['status'])
			->setCreatedAt();
	}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize()
	{
		return $this->data;
	}
}
