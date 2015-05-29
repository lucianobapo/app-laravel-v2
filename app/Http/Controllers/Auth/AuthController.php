<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Repositories\MessagesRepository;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

    protected $redirectTo = '/delivery';
    protected $redirectAfterLogout = '/delivery';

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard $auth
     * @param  \Illuminate\Contracts\Auth\Registrar $registrar
     */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

    /**
     * Override parent Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @param MessagesRepository $repository
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request, MessagesRepository $repository)
    {
        $validator = $this->registrar->validator($request->all());

        if ($validator->fails())
        {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $createUser = $this->registrar->create($request->all());

        //dd($request->all());
        // Send message if the User successful created
        if (is_object($createUser)) {
            $repository->setFields($request->all());
            $repository->messageUserCreated();
        }

        $this->auth->login($createUser);

        return redirect($this->redirectPath());
    }

}
