<?php

namespace App\Repositories;

use App\Http\Resources\BlogIndexResource;
use App\Http\Resources\BlogManageResource;
use App\Http\Resources\BlogManageTrashedResource;
use App\Interfaces\BlogRepositoryInterface;
use App\Models\Blog;
use DataTables;
use Illuminate\Support\Str;

class BlogRepository implements BlogRepositoryInterface{

    public function index($request, $dataTable)
    {

        if($request->ajax() || $request->wantsJson()){
            $data = Blog::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->setTransformer(function ($item){
                    return BlogManageResource::make($item)->resolve();
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('title'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['title'], $request->get('title')) ? true : false;
                        });
                    }

                    if (!empty($request->get('published_at'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['published_at'], $request->get('published_at')) ? true : false;
                        });
                    }

                    if (!empty($request->get('status'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['status'], $request->get('status')) ? true : false;
                        });
                    }

                    if (!empty($request->get('search'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            if (Str::contains(Str::lower($row['title']), Str::lower($request->get('search')))) {
                                return true;
                            }

                            return false;
                        });
                    }
                }, true)
                ->make(true);
        }
        return view('blogs.index');
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
        $blog->status = 0;
        $blog->save();
        $blog = $blog->delete();
        if($blog){
            return response()->json(['message' => 'Deleted Successfully'], 201);
        }
    }

    public function deletePermanent($blog)
    {
        $blog = $blog->forceDelete();
        if($blog){
            return response()->json(['message' => 'Deleted Successfully'], 201);
        }
    }

    public function restore($blog)
    {
        $blog->status = 1;
        $blog->save();
        $blog = $blog->restore();
        if($blog){
            return response()->json(['message' => 'Restored Successfully'], 201);
        }
    }

    public function getBlogs($request)
    {
        if($request->ajax() || $request->wantsJson()){
            $data = BlogIndexResource::collection(Blog::where('status', 1)->latest()->paginate(9));
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

    /*
     * Get Trashed users
     */
    public function trashed($request)
    {
        if($request->ajax() || $request->wantsJson()){
            $data = Blog::onlyTrashed()->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->setTransformer(function ($item){
                    return BlogManageTrashedResource::make($item)->resolve();
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('title'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['title'], $request->get('title')) ? true : false;
                        });
                    }

                    if (!empty($request->get('published_at'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['published_at'], $request->get('published_at')) ? true : false;
                        });
                    }

                    if (!empty($request->get('status'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['status'], $request->get('status')) ? true : false;
                        });
                    }

                    if (!empty($request->get('search'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            if (Str::contains(Str::lower($row['title']), Str::lower($request->get('search')))) {
                                return true;
                            }

                            return false;
                        });
                    }
                }, true)
                ->make(true);
        }
        return view('blogs.trashed');
    }

}
