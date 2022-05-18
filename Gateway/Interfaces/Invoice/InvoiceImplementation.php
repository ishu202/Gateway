<?php


namespace App\libraries\Gateway\Interfaces\Invoice;


interface InvoiceImplementation
{
	function create();

	function update();

	function delete();

	function get();
}
