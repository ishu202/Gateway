<?php


namespace App\libraries\Gateway\Abstracts;


abstract class OrderMetaAbstracts
{
	protected array $data;

	public function __construct(array $params)
	{
		$this->data = $params;
	}


}
