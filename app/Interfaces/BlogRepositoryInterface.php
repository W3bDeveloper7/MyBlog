<?php

namespace App\Interfaces;

interface BlogRepositoryInterface {
    public function index($request, $dataTable);
    public function getBlogs($request);
    public function show($blog);
    public function update($blog, $request);
    public function delete($blog);
}
