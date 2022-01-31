<?php

namespace App\Services\User;

//Services
use App\Services\BaseServices;

//Format
use App\Format\BlogFormat;

//Models
use App\Models\Blog;

class BlogServices extends BaseServices{
    private $blogModel = Blog::class;

    public function blogList($request){
        $this->logCreate($request);
        if ($request->has('q')){
            $blogs = $this->filterRI->filterBy1PropPaginated($this->blogModel, $request->q, $request->limit, 'name');
        }else{
            $blogs = $this->baseRI->listWithPagination($this->blogModel, $request->limit);
        }
        if($blogs){
            return $blogs;
            // return $blogs->through(function($blog){
            //     return BlogFormat::formatblogList($blog);
            // });
        }else{
            return response(["message"=>'blog not found'],404);
        }
    }

    public function blogGetById($request, $id){
        $this->logCreate($request);
        $blog = $this->baseRI->findById($this->blogModel, $id);
        if($blog){
            return $blog;
        }else{
            return response(["message"=>'blog not found'],404);
        }
    }

    public function blogCreate($request){
        $this->logCreate($request);
        $request->validate([
            'name'=>'required',
            'permissions'=>'required'
        ]);
        $data = $request->all();

        $blog = $this->baseRI->storeInDB($this->blogModel, $data);
        return response($blog,201);
    }

    public function blogUpdate($request, $id){
        $this->logCreate($request);
        $request->validate([
            'name'=>'required',
            'permissions'=>'required'
        ]);
        $blog = $this->baseRI->findById($this->blogModel, $id);
        if($blog){
            $data = $request->all();
            $blog->update($data);
            return response($blog,201);
        }else{
            return response(["message"=>'blog not found'],404);
        }
    }

    public function blogDelete($request, $id){
        $this->logCreate($request);
        $blog = $this->baseRI->findById($this->blogModel, $id);
        if($blog){
            $blog->delete();
            return response(["message"=>'Delete Successfull'],200);
        }else{
            return response(["message"=>'blog not found'],404);
        }
    }

}
