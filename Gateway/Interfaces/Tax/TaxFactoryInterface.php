<?php


namespace App\libraries\Gateway\Interfaces\Tax;


use App\libraries\Gateway\Interfaces\Implementation;

interface TaxFactoryInterface
{
	function createTaxFactory(): Implementation;
}
