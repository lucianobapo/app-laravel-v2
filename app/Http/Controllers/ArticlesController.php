<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Cache\Repository as CacheRepository;

//use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;


class ArticlesController extends Controller {

    /**
     * @var CacheRepository
     */
    private $cache;

    /**
     * Create a new articles controller instance.
     * @param CacheRepository $cache
     */
    public function __construct(CacheRepository $cache) {
        $this->middleware('auth',['except'=> ['index','show']]);
        //$this->middleware('guest',['only'=> ['index','show']]);

        $this->cache = $cache;
    }

    /**
     * Show all articles.
     *
     * @param Article $article
     * @return \Illuminate\View\View
     */
    public function index(Article $article) {
        //$articles= Article::latest()->get();
        //$articles= Article::latest('published_at')->get();
        //$articles= Article::latest('published_at')->where('published_at','<=',Carbon::now())->get();
        //$articles = Article::latest('published_at')->published()->get();
        $articles = $article->getCachedLatestPublished($this->cache);
	    return view('articles.index',compact('articles'));
	}

    /**
     * Show a single article.
     *
     * @param Article $article
     * @return \Illuminate\View\View
     */
    public function show(Article $article) {
    //public function show($id) {
        //$article = Article::findOrFail($id);
        return view('articles.show',compact('article'));
    }

    /**
     * Show the page to create a new article.
     *
     * @param Tag $tag
     * @return \Illuminate\View\View
     */
    public function create(Tag $tag) {
//        $tags = $tag->getCachedLists($this->cache,'name','id');
        $tags = $tag->lists('name','id');
        return view('articles.create',compact('tags'));
    }

    /**
     * Save a new article.
     *
     * @param ArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ArticleRequest $request) {
        //$input = Request::all();
        //$input['published_at'] = Carbon::now();
        //Article::create(Request::all());
        //Article::create($request->all());
        //Auth::user()->articles()->save(new Article($request->all()));
        //$article = Auth::user()->articles()->create($request->all());

        //$article->tags()->attach($request->input('tag_list'));
        //$this->syncTags($article, $request->input('tag_list'));

        $this->createArticle($request);

        //flash()->success('Your article has been created!');
        flash()->overlay(trans('article.articleCreated'),trans('article.articleCreatedTitle'));

        return redirect(route('articles.index'));
    }

    /**
     * Show the page to edit a new article.
     *
     * @param Article $article
     * @param Tag $tag
     * @return \Illuminate\View\View
     */
    public function edit(Article $article, Tag $tag) {
//        $tags = $tag->getCachedLists('name','id');
        $tags = $tag->lists('name','id');
//        $tags = Tag::lists('name','id');
        return view('articles.edit', compact('article', 'tags'));
    }

    /**
     * Update an article.
     *
     * @param Article $article
     * @param ArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Article $article, ArticleRequest $request) {
        $article->update($request->all());

        $this->syncTags($article, $request->input('tag_list'));

        flash()->overlay(trans('article.articleUpdated'),trans('article.articleUpdatedTitle'));

        return redirect(route('articles.index'));
    }

    /**
     * Sync up a list of tags in the database.
     *
     * @param Article $article
     * @param array $tags
     */
    private function syncTags(Article $article, $tags) {
        $article->tags()->sync(is_null($tags)?array():$tags);
    }

    /**
     * Save a new Article.
     *
     * @param ArticleRequest $request
     * @return mixed
     */
    private function createArticle(ArticleRequest $request) {
        $article = Auth::user()->articles()->create($request->all());
        $this->syncTags($article, $request->input('tag_list'));
        return $article;
    }
}
