<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller {

    public function show($file){
        $imageDir = config('filesystems.imageLocation') . DIRECTORY_SEPARATOR;
        if (!Storage::exists($imageDir . $file)) return abort(403, trans('app.accessUnauthorized'));

        $headers = array();
        $headers['content-type'] = Storage::mimeType($imageDir . $file);
        $headers['content-transfer-encoding'] = 'binary';
        $headers['content-disposition'] = 'inline filename="'.$file.'"';
        $headers['content-length'] = Storage::size($imageDir . $file);
        return response(Storage::get($imageDir . $file), 200, $headers);
	}

}
