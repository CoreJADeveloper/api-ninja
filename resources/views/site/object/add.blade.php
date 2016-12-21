@extends('layouts.app')

@section('object')
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{url('/object')}}">Objects</a></li>
                <li class="active">Add</li>
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
        @if(Session::has('object-add'))
            <div class="alert alert-success">
                {{ Session::pull('object-add') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <form role="form" method="post" enctype="multipart/form-data" action="{{url('/object/submit')}}">
                    <div class="form-group">
                        <label> Object Name:</label>
                        <input type="text" name="name" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label> Unique Code:</label>
                        <input type="text" name="unique_code" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label> Website Link:</label>
                        <input type="url" name="website_link" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-object-locked" class="checkbox">
                            <input type="checkbox" name="locked" data-toggle="checkbox"
                                   id="checkbox-object-locked" value="1" class="custom-checkbox">
                                <span class="icons"><span class="icon-unchecked"></span><span
                                            class="icon-checked"></span></span>
                            Locked
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-object-disabled" class="checkbox">
                            <input type="checkbox" name="disabled" data-toggle="checkbox"
                                   id="checkbox-object-disabled" value="1" class="custom-checkbox">
                                <span class="icons"><span class="icon-unchecked"></span><span
                                            class="icon-checked"></span></span>
                            Disabled
                        </label>
                    </div>
                    <div class="form-group">
                        <div class="well clearfix">
                            <label>Logo</label>
                            <input type="file" name="logo"/>
                        </div>
                    </div>
                    <div class="form-group">
                        @if(isset($data['parameters']) && !empty($data['parameters']))
                            @foreach($data['parameters'] as $key => $parameter_args)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">{!! $key !!}</h3>
                                    </div>
                                    <div class="panel-body">
                                        @foreach($parameter_args as $arg)
                                            @if($arg['parameter_field_type'] == 'String')
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>{!! $arg['parameter_name'] !!}</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="parameter[{{$arg['parameter_id']}}]" class="form-control"/>
                                                    </div>
                                                </div>
                                                <br>
                                            @endif
                                            @if($arg['parameter_field_type'] == 'Image')
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>{!! $arg['parameter_name'] !!}</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="file" name="parameter[{{$arg['parameter_id']}}]" />
                                                    </div>
                                                </div>
                                                <br>
                                            @endif
                                            @if($arg['parameter_field_type'] == 'Numeric')
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>{!! $arg['parameter_name'] !!}</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="number" name="parameter[{{$arg['parameter_id']}}]" class="form-control"/>
                                                    </div>
                                                </div>
                                                <br>
                                            @endif
                                            @if($arg['parameter_field_type'] == 'Boolean')
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>{!! $arg['parameter_name'] !!}</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="radio-param-yes-{{$arg['parameter_id']}}" class="radio">
                                                            <input type="radio" name="parameter[{{$arg['parameter_id']}}]"
                                                                   data-toggle="radio"
                                                                   id="radio-param-yes-{{$arg['parameter_id']}}" value="1"
                                                                   class="custom-radio">
                                <span class="icons"><span class="icon-unchecked"></span><span
                                            class="icon-checked"></span></span>
                                                            Yes
                                                        </label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="radio-param-no-{{$arg['parameter_id']}}" class="radio">
                                                            <input type="radio" name="parameter[{{$arg['parameter_id']}}]"
                                                                   data-toggle="radio"
                                                                   id="radio-param-no-{{$arg['parameter_id']}}" value="0"
                                                                   class="custom-radio" checked />
                                <span class="icons"><span class="icon-unchecked"></span><span
                                            class="icon-checked"></span></span>
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                                <br>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="well text-center">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <a href="{{url('/object')}}" class="btn btn-danger">Cancel</a>
                            <input type="submit" class="btn btn-success" value="Save"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection