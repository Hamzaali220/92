<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Lang;

class LangaugeController extends Controller
{
    /* For set language */
    public function index($lang = 'en', Request $request)
    {
        App::setLocale($lang);
        $locale = App::getLocale();
        Session::put('lg', $lang);
        if (Auth::check()) {
            $user = Auth::user();
            $user->language = $lang;
            $user->save();
        }
        return Redirect::back();
    }
}
