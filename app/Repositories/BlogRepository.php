<?php

namespace App\Repositories;

use App\Http\Resources\BlogIndexResource;
use App\Interfaces\BlogRepositoryInterface;
use App\Models\Blog;
use DataTables;

class BlogRepository implements BlogRepositoryInterface{

    public function index($request, $dataTable)
    {
        return $dataTable->render('blogs.index');
        $users = Blog::paginate(10);

        $resource = BlogIndexResource::collection($users);
        $users = \App\Models\Blog::paginate(10);

        $resource = \App\Http\Resources\BlogIndexResource::collection($users);


        //$data = BlogIndexResource::collection(Blog::latest()->get())->collection->pluck('resource');
//        return Datatables::of($resource)
//            ->addIndexColumn()
//            ->addColumn('action', function($row){
//                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
//                return $actionBtn;
//            })
//            ->rawColumns(['action'])
//            ->make(true);

        return DataTables::eloquent(Blog::latest())
            ->setTransformer(function ($item){
                return BlogIndexResource::make($item)->resolve();
            })->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show($blog)
    {
        return view('blogs.view', compact('blog'));
    }

    public function update($blog, $request)
    {
        // TODO: Implement update() method.
    }

    public function delete($blog)
    {
        // TODO: Implement delete() method.
    }

    public function getBlogs($request)
    {
        if($request->ajax() || $request->wantsJson()){
            $data = BlogIndexResource::collection(Blog::latest()->paginate(9));
            return $data;
        }
        return view('home');

    }
}
