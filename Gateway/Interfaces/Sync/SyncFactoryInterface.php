<?php


namespace App\libraries\Gateway\Interfaces\Sync;


interface SyncFactoryInterface
{
	public function createSyncFactory(array $params): SyncToStripeInterface;
}
