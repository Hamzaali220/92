<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App;
use Session;
use Illuminate\Http\Request;

class BeforeMiddleware	
{
	public function handle($request, Closure $next)
	{      		
   		
		if(Auth::check()):
			$lang = Auth::user()->language;
			App::setLocale($lang);
		else:
			$locale = App::getLocale();
			$langauage = Session::get('lg') && !empty(Session::get('lg'))?Session::get('lg'):App::getLocale();
			App::setLocale($langauage);	
		endif;
		
		return $next($request);
	}
}
?>