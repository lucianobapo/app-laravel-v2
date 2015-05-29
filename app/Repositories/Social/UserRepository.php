<?php namespace App\Repositories\Social;

use App\Models\User;

class UserRepository {

    /**
     * @var User
     */
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user){
        $this->user = $user;
    }

//    /**
//     * @param array $userProvider
//     * @return mixed
//     */
//    public function getDatabaseUser($userProvider){
//        return $this->user->where([
//            'mandante' => 'inicial',
//            'email' => $userProvider->email,
//        ])->first();
//    }
//
//    /**
//     * @param array $userProvider
//     * @return static
//     */
//    public function createUser($userProvider){
//        return $this->user->create([
//            'mandante' => 'inicial',
//            'name' => $userProvider->name,
//            'email' => $userProvider->email,
//            'avatar' => $userProvider->avatar,
//            'password' => bcrypt($userProvider->id),
//        ]);
//    }

    public function firstOrCreate($userProvider){

        $user = $this->user->where([
            'email' => $userProvider->email,
        ])->first();
//        dd($user);
        if (is_null($user)){
            $user = $this->user->create([
                'mandante' => 'inicial',
                'name' => $userProvider->name,
                'email' => $userProvider->email,
                'avatar' => $userProvider->avatar,
                'password' => bcrypt($userProvider->id),
            ]);
//            dd($user);
        }
        return $user;
    }
}