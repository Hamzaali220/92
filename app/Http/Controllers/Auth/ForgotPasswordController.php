<?php

namespace App\Http\Controllers\Auth;

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

class ForgotPasswordController extends Controller
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

    /* For reset code send */
    public function resetcodesend(Request $request)
    {

        $this->validate($request, ['email' => 'required|email']);
        $user = new User;
        $userExits = $user->getDetailsByEmailOrId(array('email' => $request->input('email')));
        $emailsuccesssend = false;
        if (!empty($userExits)) {

            $SecurtyQuestion = new SecurtyQuestion;
            $securtyquestion = $SecurtyQuestion->getSecurtyQuestionByuserid($userExits->id);
            $redirect = Redirect::back()->withInput()->with(array("email_right" => $request->input('email'), "userdata" => $securtyquestion));

            if (empty($securtyquestion)) {
                $emailsuccesssend = true;
            }

            if (!empty($request->input('securty')) && $request->input('securty') == 1) {
                $rules = array(
                    'email'     => 'required|email',
                    'answer_1'  => 'required',
                    'answer_2'  => 'required'
                );

                $validator = Validator::make($request->all(), $rules);


                if ($validator->fails()) {
                    return $redirect->withErrors(["answer_1" => $validator->errors()->first('answer_1'), "answer_2" => $validator->errors()->first('answer_2')]);
                } else {
                    $send = true;
                    if ((strtolower($securtyquestion->answer_1) != strtolower($request->input('answer_1')) && (strtolower($securtyquestion->answer_2) != strtolower($request->input('answer_2'))))) {
                        return $redirect->withErrors(["answer_1" => 'The answer does not match.', "answer_2" => 'The answer does not match.']);
                        $send = false;
                    } else if (strtolower($securtyquestion->answer_2) != strtolower($request->input('answer_2'))) {
                        return $redirect->withErrors(["answer_2" => 'The answer does not match.']);
                        $send = false;
                    } else if (strtolower($securtyquestion->answer_1) != strtolower($request->input('answer_1'))) {
                        return $redirect->withErrors(["answer_1" => 'The answer does not match.']);
                        $send = false;
                    } else {

                        if ($send == true) {
                            $emailsuccesssend = true;
                        }
                    }
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
                $emaildata['rolename']=env('user_role_'.$user->agents_users_role_id);
                $emaildata['html'] = '<div><h3>Hello ' . $emaildata['name'] . ',</h3><br><p>
                Forgot Your Password 92Agents.</p>
                <br>
                <p>Click <a href="' . $emaildata['url'] . '">here</a></p><div>';

                Mail::send('email.resetpassword', $emaildata, function ($message) use ($emaildata) {
                    $message->to($emaildata['email'], $emaildata['name'])
                        ->subject('Reset Your Password 92Agents.');

                });

                if ($update == 1) {
                    return $redirect->withErrors(["msg" => "We have sent you an email with the password reset link to change the Password"]);
                } else {
                    return $redirect->withErrors(["check" => "Try Again"]);
                }
            }
            return $redirect;
        } else {
            return Redirect::back()->withInput()->withErrors(["check" => "This email address does not exist."]);
        }
    }

    /* Reset code send by admin */
    public function resetcodesendbyadmin($email)
    {
        // print_r($email); exit;
        $user = new User;
        $userExits = $user->getDetailsByEmailOrId(array('email' => $email));
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
                <p>Click <a href="' . $emaildata['url'] . '">here</a></p><div>';

        Mail::send([], [], function ($message) use ($emaildata) {
            $message->to($emaildata['email'], $emaildata['name'])
                ->subject('Forgot Your Password 92Agents.')
                ->setBody($emaildata['html'], 'text/html');
            $message->from('92agent@92agents.com', '92agent@92agents.com');
        });

        if ($update == 1) {
            return Redirect::back()->with(["msg" => "We have sent you an email with the password reset link to change the Password"]);
        } else {
            return Redirect::back()->with(["ms" => "Try Again"]);
        }
    }




    /* For resete password form */
    public function resetpasswordform($token = null)
    {
        $data = array();
        $validator = Validator::make(array('token1' => $token), array('token1' => 'required'));
        if ($validator->fails()) :
            $data['token'] = 'This password reset token is required.';
        else :
            $user = new User;
            $userExits = $user->getDetailsByEmailOrId(array('forgot_token' => $token));
            if (!empty($userExits)) {
                // $user = User::find($userExits->id);
                // $user->forgot_token = '';
                // $update = $user->save();
                $data['user'] = $userExits;
            } else {
                $data['token'] = 'This password reset token is invalid.';
            }
        endif;
        return view('front.publicPage.resetpasswordform', $data);
    }

    /* For reset password process */
    public function resetpassword(Request $request)
    {
        $rules = array(
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required|required_with:password|min:6'
        );
        //password update.
        $password           = $request->input('password');
        $passwordconf       = $request->input('password_confirmation');
        $this->validate($request, $rules);
        $user = User::find($request->input('userid'));
        $user->forgot_token = '';
        $user->password = Hash::make($password);
        $user->save();
        return Redirect::back()->withErrors(["msg" => "Your password has been reset successfully. <a class='btn btn-link' href='" . url('/login') . "?usertype=" . env('user_role_' . $user->agents_users_role_id) . "'> Login </a>"])->withInput();
    }
}
