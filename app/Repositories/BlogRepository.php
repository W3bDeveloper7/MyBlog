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
//        $users = Blog::paginate(10);
//
//        $resource = BlogIndexResource::collection($users);
//        $users = \App\Models\Blog::paginate(10);
//
//        $resource = \App\Http\Resources\BlogIndexResource::collection($users);


        //$data = BlogIndexResource::collection(Blog::latest()->get())->collection->pluck('resource');
//        return Datatables::of($resource)
//            ->addIndexColumn()
//            ->addColumn('action', function($row){
//                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
//                return $actionBtn;
//            })
//            ->rawColumns(['action'])
//            ->make(true);

//        return DataTables::eloquent(Blog::latest())
//            ->setTransformer(function ($item){
//                return BlogIndexResource::make($item)->resolve();
//            })->addIndexColumn()
//            ->addColumn('action', function($row){
//                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
//                return $actionBtn;
//            })
//            ->rawColumns(['action'])
//            ->make(true);
    }

    public function show($blog, $request)
    {
        if($request->ajax() || $request->wantsJson()){
            return $blog;
        }
        return view('blogs.view', compact('blog'));
    }

    public function store($request)
    {
        //image file
        $imageName = time().'.'.$request->image->extension();
        // Public Folder
        $request->image->move(public_path('images'), $imageName);

        $blog = Blog::updateOrCreate(
            ['id' => $request->blog_id],
            [
                'title' => $request->title,
                'status' => $request->status,
                'blog_content' => $request->blog_content,
                'image' => $imageName,
                'published_at' => $request->published_at,
                'user_id'   => auth()->id(),
            ]
        );
        if($blog){
            return response()->json(['message' => 'success'], 200);
        }

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

    public function getBlogsDT($request)
    {
        if($request->ajax() || $request->wantsJson()){
            return Datatables::of(Blog::latest())
                ->setTransformer(function ($item){
                    return BlogIndexResource::make($item)->resolve();
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('blogs.list');

    }

}
