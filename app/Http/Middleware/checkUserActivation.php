<?php
namespace App\Http\Middleware;
use DB;
use Closure;
use Auth;
class checkUserActivation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            $authId = Auth::user()->id;
            $userDtails = DB::table('agents_users')->where('id',$authId)->first();
            //dd($userDtails);
            if($userDtails->status == 0){
                Auth::logout();
                return redirect()->to('/login')->with('warning', 'Your account has been deactivated by the Admin.');
            }
                if($userDtails->agent_status == 2){
                return redirect()->to('/inputclosingdate');

            }
        }
        
        return $next($request);
    }
}
?>