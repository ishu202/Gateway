<?php


namespace App\libraries\Gateway\Interfaces\Source;


use App\libraries\Gateway\Interfaces\Implementation;

interface SourceFactoryInterface
{
	public function createSourceFactory(array $arr);
}
