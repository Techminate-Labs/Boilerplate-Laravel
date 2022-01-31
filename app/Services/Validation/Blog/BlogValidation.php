<?php

namespace App\Services\Validation\Blog;

class BlogValidation{
    
    public static function validate1($request){
        return $request->validate([
            'category_id'=>'required',
            'title'=>'required|string',
            'body'=>'required|string',
            'active'=>'required|string',
            'date'=>'required|string',
            'time'=>'required|string',
        ]);
    }

    public static function validate2($request){
        return $request->validate([
            'name'=>'required|string|max:255',
        ]);
    }
}