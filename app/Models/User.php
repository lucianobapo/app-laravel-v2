<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword, SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
//	protected $fillable = ['mandante', 'avatar', 'name', 'email', 'password'];
    protected $fillable = [
        'mandante',
        'name',
        'email', 'password', 'username', 'avatar','provider_id', 'provider'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    /**
     * User can have many address.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses(){
        return $this->hasMany('Address');
    }

    /**
     * User can have many articles.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles(){
        return $this->hasMany('Article');
    }

    /**
     * User can have one Partner.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function partner(){
        return $this->hasOne('Partner');
    }

    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return static
     */
    public static function create(array $attributes)
    {
        $attributes['mandante'] = 'teste';
        $model = new static($attributes);
//        \Debugbar::info($model);
//        dd($model);
        $model->save();

        static::createPartner($model);
        return $model;
    }

    private static function createPartner($user){
        $addedPartner = (new Partner)->firstOrCreate([
            'mandante' => 'teste',
            'user_id' => $user->id,
            'nome' => $user->name,
        ]);

        $addedContact = (new Contact)->firstOrCreate([
            'mandante' => 'teste',
            'partner_id' => $addedPartner->id,
            'contact_type' => 'email',
            'contact_data' => $user->email,
        ]);

//        $addedPartner->user()->save($addedPartner);
//        $user->partner()->save($addedPartner);
//        $addedPartner->contacts()->save( (new Contact)->getAddedContact('email', $user->email));
//        $addedPartner->contacts()->save( );
    }

}
