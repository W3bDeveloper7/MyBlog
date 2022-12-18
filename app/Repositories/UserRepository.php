<?php

namespace App\Repositories;

use App\Http\Resources\UserManageResource;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository implements UserRepositoryInterface{

    public function index($request)
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

        if($request->ajax() || $request->wantsJson()){
            $data = User::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->addColumn('action', function($row){
                        $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';
                        return $actionBtn;
                    })
                ->setTransformer(function ($item){
                    return UserManageResource::make($item)->resolve();
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('name'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['name'], $request->get('name')) ? true : false;
                        });
                    }

                    if (!empty($request->get('username'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['username'], $request->get('username')) ? true : false;
                        });
                    }

                    if (!empty($request->get('status'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['status'], $request->get('status')) ? true : false;
                        });
                    }

                    if (!empty($request->get('role_id'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['role_id'], $request->get('role_id')) ? true : false;
                        });
                    }

                    if (!empty($request->get('search'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                             if (Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                                return true;
                            }

                            return false;
                        });
                    }
                }, true)
                ->make(true);
        }
        return view('subscribers.index');
    }

    public function show($user, $request)
    {
            return response()->json($user);
    }

    public function store($request)
    {

        $user = User::updateOrCreate(
            ['id' => $request->user_id],
            [
                'name' => $request->name,
                'status' => $request->status,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
            ]
        );
        if($user){
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

    public function getUsers($request)
    {
        // TODO: Implement getUsers() method.
    }
}
