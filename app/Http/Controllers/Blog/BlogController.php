<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Service
use App\Services\Blog\BlogServices;

class BlogController extends Controller
{
    private $blogServices;

    public function __construct(BlogServices $blogServices){
        $this->services = $blogServices;
    }

    public function blogList(Request $request)
    {
        return $this->services->blogList($request);
    }

    public function blogGetById(Request $request, $id)
    {
        return $this->services->blogGetById($request, $id);
    }
   
    public function blogCreate(Request $request)
    {
        return $this->services->blogCreate($request);
    }

    public function blogUpdate(Request $request, $id)
    {
        return $this->services->blogUpdate($request, $id);
    }
   
    public function blogDelete(Request $request, $id)
    {
        return $this->services->blogDelete($request, $id);
    }
}