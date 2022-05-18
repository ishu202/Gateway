<?php


namespace App\libraries\Gateway\Interfaces\Transactions;


interface TransactionFactoryInterface
{
	public function createTransactionFactory(array $params);
}
