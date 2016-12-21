@extends('layouts.app')

@section('parameter')
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{url('/parameter')}}">Parameters</a></li>
                <li class="active">Edit</li>
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
        @if(Session::has('parameter-update'))
            <div class="alert alert-success">
                {{ Session::pull('parameter-update') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <form role="form" method="post" action="{{url('/parameter/update')}}">
                    <div class="form-group">
                        <label> Parameter Name:</label>
                        <input type="text" name="name" value="{!! $data['parameter']->name !!}" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label> Category:</label>
                        <select id="parameter-categories" name="category" class="chosen-select form-control">
                            @if(isset($data['categories']) && !empty($data['categories']))
                                @foreach($data['categories'] as $category)
                                    @if($category->id == $data['parameter']->category_id)
                                        <option value="{{$category->id}}" selected>{!! $category->name !!}</option>
                                    @else
                                        <option value="{{$category->id}}">{!! $category->name !!}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label> Field Type:</label>
                        <select id="field-type" name="field-type" class="form-control">
                            @if($data['parameter']->field_type == 'String')
                                <option value="String" selected>String</option>
                            @else
                                <option value="String">String</option>
                            @endif
                            @if($data['parameter']->field_type == 'Boolean')
                                <option value="Boolean" selected>Boolean</option>
                            @else
                                <option value="Boolean">Boolean</option>
                            @endif
                            @if($data['parameter']->field_type == 'Image')
                                <option value="Image" selected>Image</option>
                            @else
                                <option value="Image">Image</option>
                            @endif
                            @if($data['parameter']->field_type == 'Numeric')
                                <option value="Numeric" selected>Numeric</option>
                            @else
                                <option value="Numeric">Numeric</option>
                            @endif

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-parameter-rating" class="checkbox">
                            @if($data['parameter']->enable_rating == 1)
                                <input type="checkbox" name="enable-rating" data-toggle="checkbox"
                                       id="checkbox-parameter-rating" value="1" class="custom-checkbox"
                                       checked="checked"/>
                            @else
                                <input type="checkbox" name="enable-rating" data-toggle="checkbox"
                                       id="checkbox-parameter-rating" value="1" class="custom-checkbox"/>
                            @endif
                            <span class="icons"><span class="icon-unchecked"></span><span
                                        class="icon-checked"></span></span>
                            Enable Rating
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-parameter-filtering" class="checkbox">
                            @if($data['parameter']->enable_filtering == 1)
                                <input type="checkbox" name="enable-filtering" data-toggle="checkbox"
                                       id="checkbox-parameter-filtering" value="1" class="custom-checkbox"
                                       checked="checked"/>
                            @else
                                <input type="checkbox" name="enable-filtering" data-toggle="checkbox"
                                       id="checkbox-parameter-filtering" value="1" class="custom-checkbox"/>
                            @endif
                            <span class="icons"><span class="icon-unchecked"></span><span
                                        class="icon-checked"></span></span>
                            Enable Filtering
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-parameter-mandatory" class="checkbox">
                            @if($data['parameter']->mandatory == 0)
                                <input type="checkbox" name="mandatory" data-toggle="checkbox"
                                       id="checkbox-parameter-mandatory" value="1" class="custom-checkbox"/>
                            @else
                                <input type="checkbox" name="mandatory" data-toggle="checkbox"
                                       id="checkbox-parameter-mandatory" value="1" class="custom-checkbox"
                                       checked="checked"/>
                            @endif
                            <span class="icons"><span class="icon-unchecked"></span><span
                                        class="icon-checked"></span></span>
                            Mandatory
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-parameter-disabled" class="checkbox">
                            @if($data['parameter']->disabled == 0)
                                <input type="checkbox" name="disabled" data-toggle="checkbox"
                                       id="checkbox-parameter-disabled" value="1" class="custom-checkbox"/>
                            @else
                                <input type="checkbox" name="disabled" data-toggle="checkbox"
                                       id="checkbox-parameter-disabled" value="1" class="custom-checkbox"
                                       checked="checked"/>
                            @endif
                            <span class="icons"><span class="icon-unchecked"></span><span
                                        class="icon-checked"></span></span>
                            Disabled
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="parameter-id" value="{{$data['parameter']->id}}"/>
                        <input type="hidden" name="previous-category-id" value="{{$data['parameter']->category_id}}"/>
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <a href="{{url('/parameter')}}" class="btn btn-danger">Cancel</a>
                        <input type="submit" class="btn btn-success" value="Update"/>
                    </div>
                </form>
            </div>
        </div>
        <hr />
    </div>
@endsection