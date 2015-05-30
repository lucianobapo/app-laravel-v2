<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ProductsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param Order $order
     * @return Response
     */
    public function index(Product $product, $host)
    {
        return view('products.index', compact('host'))->with([
            'products' => $product->all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Product $product, ProductRequest $request, $host)
    {
        // doing the validation, passing post data, rules and the messages
        $uploadedFile = $request->file('imagem');
        $clientOriginalName = str_slug(substr($uploadedFile->getClientOriginalName(),0,-4)).'.'.$uploadedFile->getClientOriginalExtension();
        // checking file is valid.
        if ($uploadedFile->isValid()) {
            $imageDir = config('filesystems.imageLocation') . DIRECTORY_SEPARATOR;
            if (!Storage::exists($imageDir)) Storage::makeDirectory($imageDir);
            Storage::put($imageDir . $clientOriginalName, $uploadedFile);
        } else {
            dd($clientOriginalName);
//                // sending back with error message.
//                Session::flash('error', 'uploaded file is not valid');
//                return redirect(route('products.index', $host));
        }
        $attributes = $request->all();
        $attributes['mandante'] = 'teste';
        $attributes['imagem'] = $clientOriginalName;
        $product->create($attributes);
        flash()->overlay(trans('product.productCreated'),trans('product.productCreatedTitle'));

        return redirect(route('products.index', $host));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
