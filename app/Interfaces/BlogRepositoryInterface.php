<?php

namespace App\Interfaces;

interface BlogRepositoryInterface {
    public function index($request, $dataTable);
    public function getBlogs($request);
    public function getBlogsDT($request);
    public function show($blog, $request);
    public function store($request);
    public function delete($blog);
    public function trashed($request);
    public function restore($blog);
    public function deletePermanent($blog);
}
