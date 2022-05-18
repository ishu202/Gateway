<?php


namespace App\libraries\Gateway\Interfaces\Transactions;


interface TransactionInterface
{
	public function reset();

	public function setId();

	public function setMetadata();

	public function setAmount();
}
