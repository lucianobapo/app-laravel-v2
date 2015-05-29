<?php namespace App\Repositories\Social;

//use App\Models\User;
use App\Repositories\Social\UserRepository;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Laravel\Socialite\Contracts\Factory as Socialite;

class AuthenticateUserRepository {

//    use AuthenticatesAndRegistersUsers;

    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var Socialite
     */
    private $socialite;
    /**
     * @var Authenticatable
     */
    private $auth;
    /**
     * @var Registrar
     */
    private $registrar;

    public function __construct(UserRepository $users, Socialite $socialite, Guard $auth, Registrar $registrar){
//    public function __construct(UserRepository $users, Socialite $socialite, Authenticatable $auth){

        $this->users = $users;
        $this->socialite = $socialite;
        $this->auth = $auth;
        $this->registrar = $registrar;
    }

    /**
     * @param $hasCode
     * @param SocialAuthListener $listener
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute($hasCode, SocialAuthListener $listener, $provider){

        //Check $hasCode param
        if (!$hasCode) return $this->getAuthorizationFirst($provider);

        // Get provider user
        $userProvider = $this->getUserProvider($provider);

        // Get database user
        $userDatabase = $this->users->firstOrCreate($userProvider);

        // Attempt to login
        if ($this->auth->attempt([
            'email' => $userProvider->email,
            'password' => $userProvider->id,
        ], false)) {
            return $listener->userHasLoggedIn($userProvider);
        } else {
            return $listener->userHasFailedLoggedIn($userProvider);
        }


//        $validator = $this->registrar->validator([
//            'mandante' => 'inicial',
//            'email' => $userProvider->email,
//        ]);

        //dd($validator);

        //Get database user and check
//        if (is_null($userCollection = $this->users->getDatabaseUser($userProvider))) {
//        if ($validator->fails()) {
//            // Create if not exists
////            $this->users->createUser($userProvider);
//            $this->registrar->create([
//                'mandante' => 'inicial',
//                'name' => $userProvider->name,
//                'email' => $userProvider->email,
//                'avatar' => $userProvider->avatar,
//                'password' => $userProvider->id,
//            ]);
//        } else { //if ($userCollection->avatar!=$userProvider->avatar) {
//            //dd($validator);
//            // Return fail if already exists
//            return $listener->loginFailedEmailExists($userProvider);
//        }

//        // Attempt to login
//        if ($this->auth->attempt([
//            'email' => $userProvider->email,
//            'password' => $userProvider->id,
//        ], false)) {
//            return $listener->userHasLoggedIn($userProvider);
//        } else {
//            return $listener->userHasFailedLoggedIn($userProvider);
//        }
    }

    /**
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function getAuthorizationFirst($provider){
        return $this->socialite->driver($provider)->redirect();
    }

    /**
     * @param $provider
     * @return array
     */
    private function getUserProvider($provider){
        return $this->socialite->driver($provider)->user();
    }


}