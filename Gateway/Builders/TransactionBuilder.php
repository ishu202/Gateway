<?php


namespace App\libraries\Gateway\Builders;


use App\libraries\Gateway\Abstracts\BuilderAbstracts;
use stdClass;

class TransactionBuilder extends BuilderAbstracts
{
	protected function reset()
	{
		$this->data = new stdClass();
	}

	protected function setResponse(array $param): TransactionBuilder
	{
		$res = [];
		foreach ($param['response'] as $response) {
			$res[] = $response;
		}
		$this->data->response = $res;
		return $this;
	}

	protected function setType(array $params): TransactionBuilder
	{
		$this->data->type = $params['type'];
		return $this;
	}

	protected function setStatus(array $params): TransactionBuilder
	{
		$this->data->status = $params['status'];
		return $this;
	}

	protected function setOrderId(array $params): TransactionBuilder
	{
		$this->data->status = $params['order_id'];
		return $this;
	}

	public function get()
	{
		return $this->data;
	}

	public function set(array $params)
	{
		$this->reset();
		$this->setResponse($params)
			->setStatus($params)
			->setType($params)
			->setOrderId($params);
	}
}
