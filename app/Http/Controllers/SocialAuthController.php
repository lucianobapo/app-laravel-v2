<?php namespace App\Http\Controllers;

use App\Repositories\Social\AuthenticateUserRepository;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Social\SocialAuthListener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller implements SocialAuthListener
{
    protected $redirectTo = '/delivery';
    protected $redirectAfterLogout = '/delivery';

    /**
     * @param AuthenticateUserRepository $authenticateUser
     * @param Request $request
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function login(AuthenticateUserRepository $authenticateUser, Request $request, $provider){
        Auth::login();
        return $authenticateUser->execute($request->has('code'), $this, $provider);
	}

    /**
     * @param $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function userHasLoggedIn($user) {
//        return ('Usuário logado');
//        flash(trans('social.userHasLoggedIn'));
        flash()->success(trans('social.userHasLoggedIn'));
//        return redirect(route('delivery.index', $host));
//        return redirect()->intended();
        return redirect()->intended($this->redirectPath());
    }

    public function userHasFailedLoggedIn($user) {
//        return ('Usuário não logado');
//        return redirect('social');
        flash()->error(trans('social.userHasFailedLoggedIn'));
//        return redirect()->intended();
        return redirect()->intended($this->redirectPath());
//        return redirect(route('home.index'));
    }

//    public function loginFailedEmailExists($user) {
////        return ('Usuário já existe');
////        return redirect('social');
//        flash()->error(trans('social.loginFailedEmailExists'));
//        return redirect('delivery.index');
//    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath'))
        {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
}
