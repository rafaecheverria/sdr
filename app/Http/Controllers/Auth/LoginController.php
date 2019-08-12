<?php

namespace App\Http\Controllers\Auth;

use App\Persona;
use App\User;
use App\Mail\VerifyEmail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Mail;


class LoginController extends Controller
{

    // use AuthenticatesUsers;

    protected $redirectTo = '/main';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

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
     
        }else{
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
        return 'email';
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/login');
    }

    protected function loggedOut(Request $request)
    {
        //
    }

    public function enviarEnlace($id){

        // $user = array(User::join("personas", "users.id", "=",  "personas.id")
        //             ->select(["users.id as id", 
        //                       "users.usuario as usuario", 
        //                       "users.confirmation_code as confirmation_code",
        //                       "personas.rut as rut"])
        //             ->where("users.id", $id)
        //             ->get()
        //             ->first());

        $user = array(User::select(["users.id as id", 
                                    "users.usuario as usuario", 
                                    "users.confirmation_code as confirmation_code",
                                    "users.rut as rut"])
                            ->where("users.id", $id)
                            ->get()
                            ->first());

        // return $user[0]->rut;

        $data = ([
            "rut" => $user[0]->rut,
            "usuario" => $user[0]->usuario,
            "confirmation_code" => $user[0]->confirmation_code,
        ]);

        Mail::send("emails.confirmation_code", $data, function($message) use($data){

            $message->to($data["usuario"], $data["rut"])->subject("Por favor confirma tu correo");

        });

    }
}
