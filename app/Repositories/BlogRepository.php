<?php

namespace App\Repositories;

use App\Http\Resources\BlogIndexResource;
use App\Http\Resources\BlogManageResource;
use App\Interfaces\BlogRepositoryInterface;
use App\Models\Blog;
use DataTables;

class BlogRepository implements BlogRepositoryInterface{

    public function index($request, $dataTable)
    {

        //
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

//        if($request->ajax() || $request->wantsJson()){
//            return DataTables::eloquent(Blog::latest())
//                ->addIndexColumn()
//                ->rawColumns(['action'])
////                ->setTransformer(function ($item){
////                    return BlogManageResource::make($item)->resolve();
////                })
//                ->filter(function ($query) {
//                    if (request()->has('title')) {
//                        $query->where('title', 'like', "%" . request('title') . "%");
//                    }
//
//                    if (request()->has('published_at')) {
//                        $query->whereDate('published_at', request('published_at') );
//                    }
//
//                    if (request()->has('status')) {
//                        $query->where('status', request('status'));
//                    }
//                }, true)
//                ->make(true);
//        }
        return $dataTable->render('blogs.index');
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
