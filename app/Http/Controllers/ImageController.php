<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

class ImageController extends Controller {

    public function show($file){
//        dd($file);
        $imageDir = config('filesystems.imageLocation') . DIRECTORY_SEPARATOR;
//        dd(Storage::size($imageDir . $file));
        if (!Storage::exists($imageDir . $file)) return abort(403, trans('app.accessUnauthorized'));

        $headers = array();
        $headers['content-type'] = 'image/jpg';
        $headers['content-transfer-encoding'] = 'binary';
        $headers['content-disposition'] = 'inline filename="'.$file.'"';
        $headers['content-length'] = Storage::size($imageDir . $file);

        return response(Storage::get($imageDir . $file), 200, $headers);
	}

}
