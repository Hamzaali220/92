<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\SecurtyQuestion;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /*forgot password */
    public function resetcodesend(Request $request)
    {

        $this->validate($request, ['email' => 'required|email']);
        $user = new User;
        $userExits = $user->getDetailsByEmailOrId(array('email' => $request->input('email')));
        $emailsuccesssend = false;
        if (!empty($userExits)) {

            $SecurtyQuestion = new SecurtyQuestion;
            $securtyquestion = $SecurtyQuestion->getSecurtyQuestionByuserid($userExits->id);
            // $redirect = Redirect::back()->withInput()->with(array("email_right" => $request->input('email'), "userdata" => $securtyquestion));



            if (empty($securtyquestion && $request->input('securty') != 1)) {
                $emailsuccesssend = true;
            } else {
                return response()->json(['status' => '103', "email_right" => $request->input('email'), "userdata" => $securtyquestion]);
            }


            if (!empty($request->input('securty')) && $request->input('securty') == 1) {
                $rules = array(
                    'email'     => 'required|email',
                    'answer_1'  => 'required',
                    'answer_2'  => 'required'
                );

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(["answer_1" => $validator->errors()->first('answer_1'), "answer_2" => $validator->errors()->first('answer_2')],422);
                } else
                if (strtolower($securtyquestion->answer_1) != strtolower($request->input('answer_1'))) {
                    return response()->json(['status' => '101', "error" => 'The answer is not match.']);
                } else
                if (strtolower($securtyquestion->answer_2) != strtolower($request->input('answer_2'))) {
                    // return $redirect->withErrors([]);
                    return response()->json(['status' => '101', "error" => 'The answer does not match.']);
                } else {
                    $emailsuccesssend = true;
                }
            }
            if ($emailsuccesssend) {
                $resetlink = str_replace('/', '', Hash::make($user->randPassword()));
                $user = User::find($userExits->id);
                $user->forgot_token = $resetlink;
                $update = $user->save();

                $emaildata['email'] = $userExits->email;
                $emaildata['url']  = url('/password/code/' . $resetlink);
                $emaildata['name'] = ucwords($userExits->name);
                $emaildata['html'] = '<div><h3>Hello ' . $emaildata['name'] . ',</h3><br><p>
                Forgot Your Password 92Agents.</p>
                <br>
                <p>Clcik <a href="' . $emaildata['url'] . '">here</a></p><div>';

                Mail::send([], [], function ($message) use ($emaildata) {
                    $message->to($emaildata['email'], $emaildata['name'])
                        ->subject('Forgot Your Password 92Agents.')
                        ->setBody($emaildata['html'], 'text/html');
                    $message->from('92agent@92agents.com', '92agent@92agents.com');
                });

                if ($update == 1) {
                    return response()->json(['status' => '100', 'response' => 'We have sent you an email with the password reset link to change the Password']);
                } else {
                    return response()->json(['status' => '101', 'error' => 'Try Again']);
                }
            }
            return response()->json(['status' => '101', 'error' => 'Try Again']);
        } else {
            return response()->json(['status' => '101', 'error' => 'This email address does not exist.']);
        }
    }
}
