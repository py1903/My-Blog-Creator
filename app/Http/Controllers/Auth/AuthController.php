<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Validator;

class AuthController extends Controller {

    use AuthenticatesAndRegistersUsers;

	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
		$this->middleware('ajax', ['only' => ['postLogin', 'getLogout']]);
	}

	public function postLogin(Request $request)
	{
		$this->auth->login();

		return response()->json(['response' => 'login']);
	}

	public function getLogout(Request $request)
	{
		$this->auth->logout();

		return response()->json(['response' => 'logout']);
	}

}