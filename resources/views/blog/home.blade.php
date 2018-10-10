@extends('layouts.app')

@section('content')

    @if(isset($result))
        @if(isset($result['token']))
            <a href="{{ route('blog.posts.index') }}">SHOW POST</a>
        @else
            <p>{{ $result[0] }}</p>
        @endif
    @else
        <p>Khong ton tai</p>
    @endif

@endsection
