<?php

namespace App\Http\Controllers;

use App\DataTables\BlogsDataTable;
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
}
