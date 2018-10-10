
@extends('layouts.app')

@section('content')
    @if(isset($errors))
        <div class="alert alert-danger">
            @foreach($errors as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
        <button><a style="text-decoration: none" href="{{ route('blog.login') }}">Back</a></button>
    @endif
@endsection
