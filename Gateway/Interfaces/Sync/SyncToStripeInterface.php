<?php


namespace App\libraries\Gateway\Interfaces\Sync;


interface SyncToStripeInterface
{
	public function sync();

	public function sync_data_from_stripe();

	public function format_stripe_response();
}
