<?php


namespace App\libraries\Gateway\Providers;


use App\libraries\Gateway\Factory\SourceFactory;
use App\libraries\Gateway\Interfaces\Implementation;

class SourceProvider
{
	public function provideSourceFactory(SourceFactory $factory, array $params): Implementation
	{
		return $factory->createSourceFactory($params);
	}
}
