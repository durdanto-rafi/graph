@extends('layouts.app')
@section('title', 'Create New Category')
 
@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Categories</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('category.create') }}"> Create New category</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Title</th>
            <th>Status</th>
            <th width="280px">Action</th>
        </tr>
    @foreach ($categories as $key => $category)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $category->name }}</td>
        <td>@if($category->deactivated == 0) 
                <i class="fa fa-check-square-o" aria-hidden="true"></i> 
            @else 
                <i class="fa fa-times" aria-hidden="true"></i>
            @endif 
        </td>
        <td>
            <a class="btn btn-info" href="{{ route('category.show',$category->id) }}">Show</a>
            <a class="btn btn-primary" href="{{ route('category.edit',$category->id) }}">Edit</a>

            {!! Form::open(['route' => ['category.destroy', $category->id], 'method' => 'DELETE','class'=>'frmDelete','style'=>'display:inline']) !!}
                <button class="btn btn-danger delete-btn">Delete</button>
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
    </table>

    {!! $categories->render() !!}

@endsection