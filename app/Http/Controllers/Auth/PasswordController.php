<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Http\Requests;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth, PasswordBroker $passwords)
    {
        $this->middleware('guest');
        $this->auth = $auth;
        $this->passwords = $passwords;
    }

    public function postReset(Request $request){
      $this->validate(
          $request,
          $this->getResetValidationRules(),
          $this->getResetValidationMessages(),
          $this->getResetValidationCustomAttributes()
      );

      $credentials = $this->getResetCredentials($request);

      $broker = $this->getBroker();

      $response = Password::broker($broker)->reset($credentials, function ($user, $password) use ($request) {
        $user->forceFill([
            'password' => $password,
            'remember_token' => str_random(60),
        ])->save();
        if($request->isJson()){
          Auth::guard($this->getGuard())->once(["email"=>$user->email, "password"=>$password]);
        }
        else {
          Auth::guard($this->getGuard())->login($user);
        }
      });

      switch ($response) {
          case Password::PASSWORD_RESET:
              return $this->getResetSuccessResponse($request, $response);
          default:
              return $this->getResetFailureResponse($request, $response);
      }

    }

    protected function getResetSuccessResponse($request, $response)
    {
      if($request->isJson()){
        return Auth::user();
      }
      else {
        return redirect($this->redirectPath())->with('status', trans($response));
      }

    }

    protected function getResetFailureResponse($request, $response){
        if($request->isJson()){
          return response()->json(["error"=>$response]);
        }
        else{
          return redirect()->back()
              ->withInput($request->only('email'))
              ->withErrors(['email' => trans($response)]);
        }
    }

}
