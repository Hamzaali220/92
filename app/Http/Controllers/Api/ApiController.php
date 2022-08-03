<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\State;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

   	public function states()
    {
        $state = new State;
        $posts = DB::table('agents_state')->get();
        return json_encode($posts);
    }

}
