<?php


namespace App\libraries\Gateway\Providers;


use App\libraries\Gateway\Factory\SyncFactory;

class SyncProvider
{
	public function provideSyncFactory(SyncFactory $factory, $params = []): array
	{
		return [
			$factory->createSyncFactory($params)
		];
	}
}
