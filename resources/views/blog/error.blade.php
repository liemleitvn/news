
@extends('layouts.app')

@section('content')
    @if(isset($errors))
        @foreach($errors as $error)
            <div class="alert alert-danger">
                <p>{{ $error }}</p>
            </div>
        @endforeach
    @endif
@endsection
