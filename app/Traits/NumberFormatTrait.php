<?php

namespace App\Traits;

trait NumberFormatTrait
{
	public function numberFormat($column, $prefix = '₱') {
    	$result = number_format($column, 2, '.', ',');

    	return $result;
    }
}