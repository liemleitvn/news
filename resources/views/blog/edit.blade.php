@extends('layouts.app')

@section('content')
    <form method="post" action="{{ route('blog.posts.update', ['id'=>$id]) }}">
        {{ csrf_field() }}
        <table>
            <tr>
                <td><label for="title">Title</label></td>
                <td><input type="text" name="title" id="title" value="{{ $post['title']}}"></td>
            </tr>
            <tr>
                <td><label for="category">Category</label></td>
                <td>
                    <select name="category" id="category">
                        <option value="">---Select Category---</option>
                        @foreach($category as $cate)
                            <option value="{{ $cate['id'] }}">{{ $cate['name'] }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="content">Content</label> </td>
                <td><textarea id="content" name="content">{{ $post['description'] }}</textarea></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit">Save</button>
                    <button><a style="text-decoration: none" href="{{ route('blog.posts.index') }}">Cancel</a></button>
                </td>
            </tr>
        </table>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif
    @if($message = Session::get('status'))
        <div class="alert alert-danger">
            {{ $message }}
        </div>
    @endif
@endsection
