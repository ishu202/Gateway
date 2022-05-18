<?php


namespace App\libraries\Gateway\Builders;


use App\libraries\Gateway\Abstracts\BuilderAbstracts;
use stdClass;

class OrderMetaBuilder extends BuilderAbstracts
{

	protected function reset()
	{
		$this->data = new stdClass();
		$this->data->id = $this->get_hash();
		$this->data->type = "meta_template";
	}

	public function setMetaTemplate(int $temp_id): OrderMetaBuilder
	{
		$this->data->template_id = $temp_id;
		return $this;
	}

	public function setLogLevel(string $log_name): OrderMetaBuilder
	{
		$this->data->log_name = $log_name;
		return $this;
	}

	public function setLogId(int $log_id): OrderMetaBuilder
	{
		$this->data->log_level = $log_id;
		return $this;
	}

	public function setItemId(int $item_id): OrderMetaBuilder
	{
		$this->data->item_id = $item_id;
		return $this;
	}

	public function setFieldName(string $field_name): OrderMetaBuilder
	{
		$this->data->field_name = $field_name;
		return $this;
	}

	public function setFieldValue($field_value): OrderMetaBuilder
	{
		$this->data->field_value = $field_value;
		return $this;
	}

	public function setFormula(string $opcode): OrderMetaBuilder
	{
		$this->data->formula = $opcode;
		return $this;
	}

	public function get(): stdClass
	{
		return $this->data;
	}

	public function set(array $metadata)
	{
		$this->reset();
		settype($metadata['field_value'], $metadata['field_type']);
		$this->setMetaTemplate($metadata['id'])
			->setLogId($metadata['log_id'])
			->setLogLevel($metadata['log_name'])
			->setItemId($metadata['item_id'])
			->setFieldName($metadata['field_name'])
			->setFieldValue($metadata['field_value'])
			->setFormula($metadata['item_formula']);
	}
}
