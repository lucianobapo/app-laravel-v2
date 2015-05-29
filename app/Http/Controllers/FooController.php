<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Article;
use App\Repositories\FooRepository;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class FooController extends Controller {

    private $repository;
    /**
     * @var Article
     */
    private $article;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(FooRepository $repository, Article $article, CacheRepository $cache) {
	    $this->repository = $repository;
        $this->article = $article;
        $this->cache = $cache;
    }

    public function foo() {
//        dd(trans('email.userCreatedSubject'));
//        dd(Lang::get('pagination.next'));
        return $this->repository->get();
        //return $this->article->getLatestPublished($this->cache);
	}

}
