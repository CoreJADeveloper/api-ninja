@extends('layouts.app')

@section('category')
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{url('/category')}}">Categories</a></li>
                <li class="active">Edit</li>
            </ol>
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ str_replace('category.name', 'Name', $error) }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(Session::has('category-update'))
            <div class="alert alert-success">
                {{ Session::pull('category-update') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <form role="form" method="post" action="{{url('/category/update')}}">
                    <div class="form-group">
                        <label> Category Name:</label>
                        <input type="text" name="name" value="{!! $category->name !!}" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-category-mandatory" class="checkbox">
                            @if($category->mandatory == 0)
                                <input type="checkbox" name="category[mandatory]" data-toggle="checkbox"
                                       id="checkbox-category-mandatory" value="1" class="custom-checkbox" />
                            @else
                                <input type="checkbox" name="category[mandatory]" data-toggle="checkbox"
                                       id="checkbox-category-mandatory" value="1" class="custom-checkbox" checked="checked" />
                            @endif
                            <span class="icons"><span class="icon-unchecked"></span><span
                                        class="icon-checked"></span></span>
                            Mandatory
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-category-disabled" class="checkbox">
                            @if($category->disabled == 0)
                            <input type="checkbox" name="category[disabled]" data-toggle="checkbox"
                                   id="checkbox-category-disabled" value="1" class="custom-checkbox" />
                            @else
                                <input type="checkbox" name="category[disabled]" data-toggle="checkbox"
                                       id="checkbox-category-disabled" value="1" class="custom-checkbox" checked="checked" />
                            @endif
                                <span class="icons"><span class="icon-unchecked"></span><span
                                            class="icon-checked"></span></span>
                            Disabled
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="category-id" value="{{$category->id}}" />
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <a href="{{url('/category')}}" class="btn btn-danger">Cancel</a>
                        <input type="submit" class="btn btn-success" value="Update"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection