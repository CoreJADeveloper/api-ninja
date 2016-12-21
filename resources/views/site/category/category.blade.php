@extends('layouts.app')

@section('category')
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li class="active">Categories</li>
            </ol>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-1">
                <a class="btn btn-primary customize-left" href="{{url('/category/add')}}">Add</a>
            </div>
            <div class="col-md-7">
                <div id="category-response" class="text-center">
                    @if(Session::has('category-search'))
                        <div class="alert alert-success">
                            {{ Session::pull('category-search') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <form method="post" action="{{url('/category/search')}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <input name="search" placeholder="Search a category..." type="text" class="form-control" id="search-category"/>
                </form>
            </div>
        </div>
        <br/>

        <div class="row">
            <div id="category-container">
                {!! $categories->render() !!}
                <table class="table table-stripped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mandatory</th>
                        <th>Number of Parameters</th>
                        <th>Enabled</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($categories) && !empty($categories))
                        @foreach ($categories as $category)
                            <tr>
                                <td>{!! $category->id !!}</td>
                                <td>{!! $category->name !!}</td>
                                <td>
                                    @if($category->mandatory == 1)
                                        {!! 'Yes' !!}
                                    @else
                                        {!! 'No' !!}
                                    @endif
                                </td>
                                <td>{!! $category->parameters !!}</td>
                                <td>
                                    @if($category->disabled == 1)
                                        <label class="checkbox">
                                            <input data-name="{{$category->name}}" data-url="{{url('')}}"
                                                   data-csrf="{{csrf_token()}}"
                                                   id="{{ $category->id }}" type="checkbox" name="category[mandatory]"
                                                   data-toggle="checkbox"
                                                   value="1" class="custom-checkbox enable-disable-category"/>
                                            <span class="icons"><span class="icon-unchecked"></span><span
                                                        class="icon-checked"></span></span>
                                        </label>
                                    @else
                                        <label class="checkbox">
                                            <input data-name="{{$category->name}}" data-url="{{url('')}}"
                                                   data-csrf="{{csrf_token()}}"
                                                   id="{{ $category->id }}" type="checkbox" name="category[mandatory]"
                                                   data-toggle="checkbox"
                                                   value="1" class="custom-checkbox enable-disable-category"
                                                   checked="checked"/>
                                            <span class="icons"><span class="icon-unchecked"></span><span
                                                        class="icon-checked"></span></span>
                                        </label>
                                    @endif
                                </td>
                                <td>
                                    @if($category->mandatory == 1)
                                        {!! 'Edit/Delete manually' !!}
                                    @else
                                        <a href="{{url('/category/edit/'.$category->id)}}"
                                           class="btn btn-warning btn-xs"><i
                                                    class="fa fa-pencil fa-btn"></i>Edit</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>There is no category created yet</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {!! $categories->links() !!}
            </div>
        </div>
    </div>
@endsection