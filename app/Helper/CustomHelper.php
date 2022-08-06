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