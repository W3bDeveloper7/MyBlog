<?php

namespace App\Interfaces;

interface UserRepositoryInterface {
    public function index($request);
    public function getUsers($request);
    public function store($request);
    public function delete($blog);
}
