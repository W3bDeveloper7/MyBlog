<?php

namespace App\Interfaces;

interface UserRepositoryInterface {
    public function index($request);
    public function store($request);
    public function delete($user);
    public function trashed($request);
    public function restore($user);
    public function deletePermanent($user);
}
