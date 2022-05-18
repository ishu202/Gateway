<?php


namespace App\libraries\Gateway\Builders;


use App\libraries\Gateway\Abstracts\BuilderAbstracts;
use Exception;
use stdClass;

class MetadataBuilder extends BuilderAbstracts
{

	protected function reset()
	{
		$this->data = new stdClass();
	}

	protected function setId($id): MetadataBuilder
	{
		$this->data->id = $id;
		return $this;
	}

	protected function setUuid($uuid)
	{
		$this->data->uuid = $uuid ?: $this->get_hash();
		return $this;
	}

	protected function setName($name): MetadataBuilder
	{
		$this->data->name = $name;
		return $this;
	}

	protected function setStatus($status): MetadataBuilder
	{
		$this->data->status = (string)$status;
		return $this;
	}

	protected function setUnits($units): MetadataBuilder
	{
		$this->data->units = $units;
		return $this;
	}

	protected function setDateFrom($from): MetadataBuilder
	{
		$this->data->from = $from;
		return $this;
	}

	protected function setDateTo($to): MetadataBuilder
	{
		$this->data->to = $to;
		return $this;
	}

	/**
	 * @throws Exception
	 */
	protected function setPickTime($pick): MetadataBuilder
	{
		$this->data->pick_time = $this->format_time($pick);
		return $this;
	}

	/**
	 * @throws Exception
	 */
	protected function setDropTime($drop): MetadataBuilder
	{
		$this->data->drop_time = $this->format_time($drop);
		return $this;
	}

	private function setDeliveryMethod(int $delivery_method)
	{
		$this->data->delivery_method = $delivery_method;
	}

	public function get(): stdClass
	{
		return $this->data;
	}

	/**
	 * @throws Exception
	 */
	public function set(array $params = [])
	{
		$this->reset();
		if (count($params))
			$this->setId($params['id'])
				->setUuid($params['uuid'])
				->setName($params['name'])
				->setStatus($params['status'])
				->setUnits($params['units'])
				->setDateFrom($params['from'])
				->setDateTo($params['to'])
				->setPickTime($params['pick_time'])
				->setDropTime($params['drop_time'])
				->setDeliveryMethod($params['delivery_method'] ?: 1);
	}
}
