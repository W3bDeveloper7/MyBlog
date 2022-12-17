@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-start">
            <div class="col-6 pt-4">
                <img src="{{ $blog->image }}" class="img-thumbnail img-fluid">
            </div>
            <div class="col-6 pt-5">
                <div class="post-heading pt-5">
                    <h1>{{ $blog->title }}</h1>

                    <span class="meta">Posted by
              <a href="#">{{ $blog->user->name }}</a>
                        {{ \Carbon\Carbon::parse($blog->published_at)->diffForHumans() }}
            </span>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-8 pt-5">
                <p>
                    {{ $blog->blog_content }}
                </p>
            </div>
        </div>

    </div>

@endsection

