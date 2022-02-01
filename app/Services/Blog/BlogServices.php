<?php

namespace App\Services\Blog;

//Services
use App\Services\BaseServices;
use App\Services\Validation\Blog\BlogValidation;

//Format
use App\Format\BlogFormat;

//Utilities
use App\Utilities\FileUtilities;

//Models
use App\Models\Blog;

class BlogServices extends BaseServices{
    public static $imagePath = 'images/blog';
    public static $explode_at = "blog/";

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
        $fields = blogValidation::validate1($request);
        $image = FileUtilities::fileUpload($request, url(''), self::$imagePath, false, false, false);
        $blog = $this->baseRI->storeInDB(
            $this->blogModel,
            [
                'category_id' => $fields['category_id'],
                'title' => $fields['title'],
                'body' => $fields['body'],
                'active' => $fields['active'],
                'date' => $fields['date'],
                'time' => $fields['time'],
                'image' => $image
            ]);

        if($blog){
            return $blog;
        }else{
            return [] ;
        }

        return response($blog,201);
    }

    public function blogUpdate($request, $id){
        $blog = $this->baseRI->findById($this->blogModel, $id);

        if($blog){
            $fields = BlogValidation::validate1($request);
            $exImagePath = $blog->image;
            $image = FileUtilities::fileUpload($request, url(''), self::$imagePath, self::$explode_at, $exImagePath, true);
            
            $blog->update([
                'category_id' => $fields['category_id'],
                'title' => $fields['title'],
                'body' => $fields['body'],
                'active' => $fields['active'],
                'date' => $fields['date'],
                'time' => $fields['time'],
                'image' => $image
            ]);
            return response($blog,201);
        }else{
            return response(["failed"=>'blog not found'],404);
        }
    }

    public function blogDelete($request, $id){
        $this->logCreate($request);
        $blog = $this->baseRI->findById($this->blogModel, $id);
        if($blog){
            $exImagePath = $blog->image;
            FileUtilities::removeExistingFile(self::$imagePath, $exImagePath, self::$explode_at);
            $blog->delete();
            return response(["message"=>'Delete Successfull'],200);
        }else{
            return response(["message"=>'blog not found'],404);
        }
    }

}
