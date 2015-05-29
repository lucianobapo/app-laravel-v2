<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Tag;
use Illuminate\Http\Request;

class TagsController extends Controller {

    /**
     * Create a new Tags controller instance.
     */
    public function __construct() {
        $this->middleware('auth');
        //$this->middleware('guest',['only'=> ['index','show']]);
    }

    /**
     * Show All Articles for the Tag.
     *
     * @param Tag $tag
     * @return \Illuminate\View\View
     */
    public function show(Tag $tag) {
        $articles = $tag->articles()->published()->get();
        return view('articles.index', compact('articles'));
	}

}
