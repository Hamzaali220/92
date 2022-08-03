<?php 
namespace App\Helper;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\User;
use Validator;
use Session;
use Input;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
/**
* 
*/
require_once(__DIR__.'/../../vendor/stripe/stripe-php/init.php');

class StripHelper
{
	var $sp;
	var $helper;
	function __construct()
	{	
		// \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
		// $charge = \Stripe\Charge::create(['amount' => 2000, 'currency' => 'usd', 'source' => 'tok_189fqt2eZvKYlo2CTGBeg6Uq']);
		// echo $charge;
	}

}
?>