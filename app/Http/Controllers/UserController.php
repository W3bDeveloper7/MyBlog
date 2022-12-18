<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware(['role:Admin'], ['except'=>['index']]);
    }

    public function index(Request $request){
        return $this->userRepository->index($request);
    }

    public function show($user, Request $request){
        $user = User::withTrashed()->find($user);
        return $this->userRepository->show($user, $request);
    }

    public function store(RegisterRequest $request){
        return $this->userRepository->store($request);
    }

    public function delete(User $user){
        return $this->userRepository->delete($user);
    }

    public function trashed(Request $request){
        return $this->userRepository->trashed($request);
    }

    public function restoreUser($user){
        $user = User::withTrashed()->find($user);
        return $this->userRepository->restore($user);
    }

    public function deletePermanent($user){
        $user = User::withTrashed()->find($user);
        return $this->userRepository->deletePermanent($user);
    }

}
