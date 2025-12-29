<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    function upload(Request $request){
        $file=new File;
       $file->files=$request->file('file')->store('file');
       $result=$file->save();
    
        if($result){
                return ['result' => 'File uploaded successfully'];
        }else{
            return ['result' => 'File upload failed'];
        }

    }
}
