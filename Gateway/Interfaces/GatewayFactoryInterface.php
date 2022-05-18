<?php


namespace App\libraries\Gateway\Interfaces;


use App\libraries\Gateway\Interfaces\Invoice\InvoiceFactoryInterface;

interface GatewayFactoryInterface
{
	function createInvoiceFactory(): InvoiceFactoryInterface;
}
