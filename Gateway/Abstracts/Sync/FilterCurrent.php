<?php


namespace App\libraries\Gateway\Abstracts\Sync;


trait FilterCurrent
{
	protected function filter_for_current_order(array $data)
	{
		array_filter($data, function ($val) {
			return $val['metadata']['order_id'];
		});
	}
}
