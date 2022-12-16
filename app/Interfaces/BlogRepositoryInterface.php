<?php

namespace App\Interfaces;

interface BlogRepositoryInterface {
    public function index();
    public function show($blog);
    public function update($blog, $request);
    public function delete($blog);
}
