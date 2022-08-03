<?php
function est_std_datetime($date){
	return date('d M Y h:i A', strtotime($date));
}

function est_std_date($date){
	return date('d M Y', strtotime($date));
}

function est_std_time($time){
	return date('h:i A', strtotime($date));
}

function calc_92_commission($sale_price) {
    $temp = 0;
    if($sale_price <= 500000) {
        $temp = 10;
    } elseif($sale_price > 500000 && $sale_price <= 2500000) {
        $temp = 8;
    } elseif($sale_price > 2500000 && $sale_price <= 15000000) {
        $temp = 5;
    } elseif($sale_price > 15000000) {
        $temp = 3;
    }
    $temp1 = $sale_price * ($temp / 100) * (1 / 100);
    if($temp1 < 50) {
        return 50;
    }
    return $temp1;
}