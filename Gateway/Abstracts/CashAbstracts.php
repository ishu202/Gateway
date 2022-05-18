<?php


namespace App\libraries\Gateway\Abstracts;


use App\libraries\Gateway\Builders\ChargeBuilder;
use App\libraries\Gateway\Builders\CustomerBuilder;
use App\libraries\Gateway\Builders\FeesBuilder;
use App\libraries\Gateway\Builders\InvoiceBuilder;
use App\libraries\Gateway\Builders\LinesBuilder;
use App\libraries\Gateway\Builders\RefundBuilder;
use App\libraries\Gateway\Builders\TransactionBuilder;
use App\libraries\Gateway\Cash\Charge;
use CI_Controller;

abstract class CashAbstracts
{
	protected array $arr;
	protected InvoiceBuilder $invoice;
	protected LinesBuilder $lines;
	protected CustomerBuilder $customer;
	protected RefundBuilder $refund;
	protected TransactionBuilder $transaction;
	protected FeesBuilder $fees;
	protected ChargeBuilder $charge;
	protected CI_Controller $CI;

	public function __construct(array $arr)
	{
		$this->arr = $arr;
		$this->invoice = new InvoiceBuilder();
		$this->lines = new LinesBuilder();
		$this->customer = new CustomerBuilder();
		$this->refund = new RefundBuilder();
		$this->transaction = new TransactionBuilder();
		$this->fees = new FeesBuilder();
		$this->charge = new ChargeBuilder();
		$this->CI = &get_instance();
	}


}
