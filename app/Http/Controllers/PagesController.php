<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PagesController extends Controller {

	public function about() {
        $name='Luciano2';
        $people=[
            'nome1','nome2'
        ];
	    return view('pages.about',compact('name','people'));
	}

    public function contact()
    {
        return view('pages.contact');
    }

}
