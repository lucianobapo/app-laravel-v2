<?php namespace App\Providers;

use App\Repositories\Social\TwitterRepository;
use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Illuminate\Support\ServiceProvider;

class TwitterServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        //
    }

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind('twitter', function () {
            $client = new Client('https://api.twitter.com/1.1/');

            $auth = new OauthPlugin([
                'consumer_key' => config('services.twitter.consumer_key'),
                'consumer_secret' => config('services.twitter.consumer_secret'),
                'token' => config('services.twitter.token'),
                'token_secret' => config('services.twitter.token_secret'),
            ]);

            $client->addSubscriber($auth);
//            dd($client);

            return new TwitterRepository($client);
        });

	}
}
