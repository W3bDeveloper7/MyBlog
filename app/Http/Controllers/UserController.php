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

    public function show(User $user, Request $request){
        return $this->userRepository->show($user, $request);
    }

    public function store(RegisterRequest $request){
        return $this->userRepository->store($request);
    }

}
