<?php


namespace App\libraries\Gateway\Builders;


use App\libraries\Gateway\Abstracts\BuilderAbstracts;
use JsonSerializable;
use stdClass;

class LinesBuilder extends BuilderAbstracts implements JsonSerializable
{
	protected array $res = [];
	protected string $type = "pending_lines";

	protected function reset()
	{
		$this->data = new stdClass();
		$this->data->id = $this->data->id ?: "ii_" . $this->get_hash();
		if ($this->type == "invoice") {
			$this->data->id = "il_" . $this->get_hash();
		}
		$this->data->object = "data";
	}

	protected function setDescription($desc): LinesBuilder
	{
		$this->data->description = $desc;
		return $this;
	}

	protected function setMetadataBuilder(MetadataBuilder $builder, $meta = []): LinesBuilder
	{
		$builder->set($meta);
		$this->data->metadata = $builder->get();
		return $this;
	}

	protected function setQuantity($quantity): LinesBuilder
	{
		$this->data->quantity = $quantity;
		return $this;
	}

	protected function setAmount($amount): LinesBuilder
	{
		$this->data->unit_amount = $this->format_unit_amount($amount);
		$this->data->price = (object)[
			'unit_amount' => $this->format_unit_amount($amount),
			'unit_amount_decimal' => $this->format_unit_amount($amount, true)
		];
		return $this;
	}

	protected function setCustomer(string $customer)
	{
		$this->data->customer = $customer;
	}

	public function setInvoice(string $invoice = null): LinesBuilder
	{
		$this->data->invoice = $invoice;
		return $this;
	}

	public function setType(?string $type): LinesBuilder
	{
		$this->type = $type;
		return $this;
	}

	public function get()
	{
		return json_encode($this->data);
	}

	public function set(array $params = []): LinesBuilder
	{
		$this->setType(@$params['type'] ?: null);
		$this->reset();
		if ($this->type != "invoice") {
			$this->data->id = $params['id'] ?: $this->data->id;
		}
		$this->setDescription($params['desc'])
			->setInvoice($params['invoice'])
			->setMetadataBuilder(new MetadataBuilder(), $params['metadata'])
			->setQuantity($params['units'])
			->setAmount($params['amount'])
			->setCustomer($params['customer']);

		return $this;
	}


	/**
	 * @inheritDoc
	 */
	public function jsonSerialize()
	{
		return $this->data;
	}
}
