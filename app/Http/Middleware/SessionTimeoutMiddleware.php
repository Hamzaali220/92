<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SessionTimeoutMiddleware {
    protected $session;
    protected $timeout=109898900;
    // protected $timeout=1000;
    public function __construct(Store $session){
        $this->session=$session;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->updatelastactivity();
        if(!$this->session->has('lastActivityTime'))
            $this->session->put('lastActivityTime',time());
        elseif(time() - $this->session->get('lastActivityTime') > $this->getTimeOut()){
            $this->session->forget('lastActivityTime');
            $this->logoutM();
            return redirect('/login')->withErrors(['You had not activity in 15 minutes']);
        }
        $this->session->put('lastActivityTime',time());
        return $next($request);
    }

    protected function getTimeOut()
    {
        return (env('TIMEOUT')) ?: $this->timeout;
    }
    protected function logoutM()
    {
        $userupdate = User::find(Auth::user()->id);
        $userupdate->login_status           =   'Offline';
        $userupdate->updated_at         =   Carbon::now()->toDateTimeString();
        $userupdate->save();
        Auth::logout();
        Session::flush();
    }
    protected function updatelastactivity()
    {
        $userupdate = User::find(Auth::user()->id);
        $userupdate->api_token         =   Carbon::now()->toDateTimeString();
        $userupdate->login_status      =  'Online';
        $userupdate->updated_at        =   Carbon::now()->toDateTimeString();
        $userupdate->save();
    }
}

?>
