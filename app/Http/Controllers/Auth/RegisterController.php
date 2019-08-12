<?php

namespace App\Http\Controllers\Auth;

use App\Mail\VerifyEmail;
use App\User;
use App\Persona;
use App\Pais;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Mail;

class RegisterController extends Controller
{

    // use RegistersUsers;

    protected $redirectTo = '/main';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $paises = Pais::all();
        return view('auth.register', compact("paises"));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nombres' => ['required', 'string'],
            'apellidos' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'pais' => ['required', 'string'],
            'rut' => ['required', 'string'],
        ]);
    }

    public function register(Request $request)
    {

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);

        // return $this->registered($request, $user)
        //                 ?: redirect($this->redirectPath());
    }

    protected function create(array $data)
    {

        try{

            DB::beginTransaction();

            $data["confirmation_code"] = str_random(25);

            $user = new User();
            $user->rut = $data['rut'];
            $user->pais = $data['pais'];
            $user->email = $data['email'];
            $user->nombres = $data['nombres'];
            $user->apellidos = $data['apellidos'];
            $user->password = bcrypt($data['password']);
            $user->estado = 1;
            $user->confirmation_code = $data["confirmation_code"];

            $user->porcentaje = 30;

            $user->save();

            $user->assignRole("Postulante");

            Mail::send("emails.confirmation_code", $data, function($message) use ($data){

                $message->to($data["email"], $data["rut"])->subject("Por favor confirma tu correo");

            });

            DB::commit();

        }catch(Exeption $e){

            DB::rollback();

        }

    }

    public function verify($code)
    {
       $user = User::where("confirmation_code", $code)->first();
       if(!$user)
       {
           return redirect("/");
       }

       $user->confirmed = true;
       $user->confirmation_code = null;
       $user->save();

       return redirect("login");

    }

}
