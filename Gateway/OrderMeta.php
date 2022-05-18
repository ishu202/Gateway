<?php


namespace App\libraries\Gateway;


use App\libraries\Gateway\Abstracts\OrderMetaAbstracts;
use App\libraries\Gateway\Builders\OrderMetaBuilder;
use App\libraries\Gateway\Interfaces\OrderTemplateMeta\OrderMetaInterface;

class OrderMeta extends OrderMetaAbstracts implements OrderMetaInterface
{

	public function add()
	{
		$this->data['result'] = array_reduce($this->data['data'], function ($memo, $data) {
			$builder = new OrderMetaBuilder();
			$builder->set($data);
			$memo[] = $builder->get();
			return $memo;
		}, []);
	}

	public function update()
	{
		// TODO: Implement update() method.
	}

	public function delete()
	{
		// TODO: Implement delete() method.
	}

	public function get()
	{
		return $this->data['result'];
	}
}
