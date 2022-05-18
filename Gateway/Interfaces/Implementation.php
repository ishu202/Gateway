<?php


namespace App\libraries\Gateway\Interfaces;


interface Implementation
{
	function create();

	function update();

	function delete();

	function get();
}
