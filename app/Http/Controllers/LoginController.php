<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function Login(LoginRequest $request)
    {

    //This section is the only change
    if ($this->guard()->validate($this->credentials($request))) {
        $user = $this->guard()->getLastAttempted();

        //Verifica si el usuario existe y si esta activado
        if ($user->confirmed == 1 && $this->attemptLogin($request)) {
            //si es usuario que se esta logeando tiene coincide con los datos de la BD y su campo confirmed 
            // es 1 se inicia sesion y se redirecciona al main mediante ajax
            return response()->json(["estado" => true]);
     
        } else {
            // Si no esta verificado envia falso al ajax y muestra un modal con un error de verificacion
            return response()->json(["estado" => false, "id" => $user->id]);
        }
    }
    // si el usuario y/o contraseña no coinciden con algun usuario de la base de datos, se envia un error de usuario inexistente
    return $this->sendFailedLoginResponse($request);

    }

    protected function attemptLogin(Request $request)
    {
            return $this->guard()->attempt(
                $this->credentials($request), $request->filled('remember')
            );
    }

    protected function sendLoginResponse(Request $request)
    {

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }


    protected function sendFailedLoginResponse(Request $request)
    {

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    public function username()
    {
        return 'usuario';
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
