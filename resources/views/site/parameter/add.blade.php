@extends('layouts.app')

@section('parameter')
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{url('/parameter')}}">Parameters</a></li>
                <li class="active">Add</li>
            </ol>
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ str_replace('parameter.name', 'Name', $error) }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(Session::has('parameter-add'))
            <div class="alert alert-success">
                {{ Session::pull('parameter-add') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <form role="form" method="post" action="{{url('/parameter/submit')}}">
                    <div class="form-group">
                        <label> Parameter Name:</label>
                        <input type="text" name="name" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label> Category:</label>
                        <select id="parameter-categories" name="category" class="chosen-select form-control">
                            @if(isset($categories) && !empty($categories))
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{!! $category->name !!}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label> Field Type:</label>
                        <select id="field-type" name="field-type" class="form-control">
                            <option value="String">String</option>
                            <option value="Boolean">Boolean</option>
                            <option value="Image">Image</option>
                            <option value="Numeric">Numeric</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-parameter-rating" class="checkbox">
                            <input type="checkbox" name="enable-rating" data-toggle="checkbox"
                                   id="checkbox-parameter-rating" value="1" class="custom-checkbox">
                                <span class="icons"><span class="icon-unchecked"></span><span
                                            class="icon-checked"></span></span>
                            Enable Rating
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-parameter-filtering" class="checkbox">
                            <input type="checkbox" name="enable-filtering" data-toggle="checkbox"
                                   id="checkbox-parameter-filtering" value="1" class="custom-checkbox">
                                <span class="icons"><span class="icon-unchecked"></span><span
                                            class="icon-checked"></span></span>
                            Enable Filtering
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-category-mandatory" class="checkbox">
                            <input type="checkbox" name="mandatory" data-toggle="checkbox"
                                   id="checkbox-category-mandatory" value="1" class="custom-checkbox">
                                <span class="icons"><span class="icon-unchecked"></span><span
                                            class="icon-checked"></span></span>
                            Mandatory
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-category-disabled" class="checkbox">
                            <input type="checkbox" name="disabled" data-toggle="checkbox"
                                   id="checkbox-category-disabled" value="1" class="custom-checkbox">
                                <span class="icons"><span class="icon-unchecked"></span><span
                                            class="icon-checked"></span></span>
                            Disabled
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <a href="{{url('/parameter')}}" class="btn btn-danger">Cancel</a>
                        <input type="submit" class="btn btn-success" value="Save"/>
                    </div>
                </form>
            </div>
        </div>
        <hr />
    </div>

@endsection