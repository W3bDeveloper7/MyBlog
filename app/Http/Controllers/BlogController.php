<?php

namespace App\Http\Controllers;

use App\DataTables\BlogsDataTable;
use App\Http\Requests\BlogStoreRequest;
use App\Models\Blog;
use App\Repositories\BlogRepository;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
//        $this->middleware(['role:Admin'], ['except'=>['index', 'show']]);
    }

    public function index(Request $request, BlogsDataTable $dataTable){
        return $this->blogRepository->index($request, $dataTable);
    }

    public function show(Blog $blog, Request $request){
        return $this->blogRepository->show($blog, $request);
    }

    public function getBlogs(Request $request){
        return $this->blogRepository->getBlogs($request);
    }

    public function getBlogsDT(Request $request){
        return $this->blogRepository->getBlogsDT($request);
    }

    public function store(BlogStoreRequest $request){
        return $this->blogRepository->store($request);
    }
}
