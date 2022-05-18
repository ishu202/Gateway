<?php


namespace App\libraries\Gateway\Factory;


use App\libraries\Gateway\Interfaces\Sync\SyncFactoryInterface;
use App\libraries\Gateway\Interfaces\Sync\SyncToStripeInterface;
use App\libraries\Gateway\Sync;

class SyncFactory implements SyncFactoryInterface
{
	private array $params;

	public function __construct(array $params)
	{
		$this->params = $params;
	}

	public function createSyncFactory(array $params = []): SyncToStripeInterface
	{
		return new Sync($this->params ?: $params);
	}
}
