<?php


namespace App\libraries\Gateway\Cash;


use App\libraries\Gateway\Abstracts\CashAbstracts;
use App\libraries\Gateway\Builders\LinesBuilder;
use App\libraries\Gateway\Interfaces\Implementation;
use stdClass;

class Lines extends CashAbstracts implements Implementation
{
	private array $lines_arr;

	function create()
	{
		$this->lines_arr = $this->lines->cash_lines_iterator_generator($this->arr['lines'], $this->lines);
	}

	function update()
	{
		$this->lines->set($this->arr['lines_update']);
	}

	function delete()
	{
		$this->lines = new LinesBuilder();
	}

	function get()
	{
		return json_encode($this->lines_arr);
	}
}
