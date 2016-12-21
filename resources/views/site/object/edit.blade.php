@extends('layouts.app')

@section('category')
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{url('/object')}}">Objects</a></li>
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
        @if(Session::has('object-update'))
            <div class="alert alert-success">
                {{ Session::pull('object-update') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <form role="form" method="post" enctype="multipart/form-data" action="{{url('/object/update')}}">
                    <div class="form-group">
                        <label> Object Name:</label>
                        <input type="text" name="name" value="{!! $data['object']->name !!}" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label> Unique Code:</label>
                        <input type="text" name="unique_code" value="{!! $data['object']->unique_code !!}"
                               class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label> Website Link:</label>
                        <input type="url" name="website_link" value="{!! $data['object']->website_link !!}"
                               class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-object-locked" class="checkbox">
                            @if($data['object']->locked == 0 )
                                <input type="checkbox" name="locked" data-toggle="checkbox"
                                       id="checkbox-object-locked" value="1" class="custom-checkbox"/>
                            @else
                                <input type="checkbox" name="locked" data-toggle="checkbox"
                                       id="checkbox-object-locked" value="1" class="custom-checkbox" checked/>
                            @endif
                            <span class="icons"><span class="icon-unchecked"></span><span
                                        class="icon-checked"></span></span>
                            Locked
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-object-disabled" class="checkbox">
                            @if($data['object']->disabled == 0 )
                                <input type="checkbox" name="disabled" data-toggle="checkbox"
                                       id="checkbox-object-disabled" value="1" class="custom-checkbox">
                            @else
                                <input type="checkbox" name="disabled" data-toggle="checkbox"
                                       id="checkbox-object-disabled" value="1" class="custom-checkbox" checked/>
                            @endif
                            <span class="icons"><span class="icon-unchecked"></span><span
                                        class="icon-checked"></span></span>
                            Disabled
                        </label>
                    </div>
                    <div class="form-group">
                        <div class="well clearfix">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Logo</label>
                                    <input type="file" name="logo"/>
                                </div>
                                <div class="col-md-6">
                                    @if($data['object']->logo != '' )
                                        <img width="100" height="70"
                                             src="{{URL::asset('/assets/logo/'.$data['object']->logo)}}"/>
                                    @endif
                                </div>
                            </div>
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
                                                        @if(array_key_exists($arg['parameter_id'], $data['object']->parameters))
                                                            <input type="text"
                                                                   value="{!! $data['object']->parameters[$arg['parameter_id']] !!}"
                                                                   name="parameter[{{$arg['parameter_id']}}]"
                                                                   class="form-control"/>
                                                        @else
                                                            <input type="text"
                                                                   name="parameter[{{$arg['parameter_id']}}]"
                                                                   class="form-control"/>
                                                        @endif
                                                    </div>
                                                </div>
                                                <br>
                                            @endif
                                            @if($arg['parameter_field_type'] == 'Image')
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>{!! $arg['parameter_name'] !!}</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="file" name="parameter[{{$arg['parameter_id']}}]"/>
                                                    </div>
                                                    <div class="col-md-4">
                                                        @if(array_key_exists($arg['parameter_id'], $data['object']->parameters))
                                                            <img width="100" class="pull-right" height="50"
                                                                 src="{{URL::asset('/assets/logo/'.$data['object']->parameters[$arg['parameter_id']])}}"/>
                                                        @endif
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
                                                        @if(array_key_exists($arg['parameter_id'], $data['object']->parameters))
                                                            <input type="number"
                                                                   value="{!! $data['object']->parameters[$arg['parameter_id']] !!}"
                                                                   name="parameter[{{$arg['parameter_id']}}]"
                                                                   class="form-control"/>
                                                        @else
                                                            <input type="number"
                                                                   name="parameter[{{$arg['parameter_id']}}]"
                                                                   class="form-control"/>
                                                        @endif
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
                                                        <label for="radio-param-yes-{{$arg['parameter_id']}}"
                                                               class="radio">
                                                            @if(!array_key_exists($arg['parameter_id'], $data['object']->parameters))
                                                                <input type="radio"
                                                                       name="parameter[{{$arg['parameter_id']}}]"
                                                                       data-toggle="radio"
                                                                       id="radio-param-yes-{{$arg['parameter_id']}}"
                                                                       value="1"
                                                                       class="custom-radio" />
                                                            @elseif(array_key_exists($arg['parameter_id'], $data['object']->parameters) && $data['object']->parameters[$arg['parameter_id']] == 1)
                                                                <input type="radio"
                                                                       name="parameter[{{$arg['parameter_id']}}]"
                                                                       data-toggle="radio"
                                                                       id="radio-param-yes-{{$arg['parameter_id']}}"
                                                                       value="1"
                                                                       class="custom-radio" checked/>
                                                            @else
                                                                <input type="radio"
                                                                       name="parameter[{{$arg['parameter_id']}}]"
                                                                       data-toggle="radio"
                                                                       id="radio-param-yes-{{$arg['parameter_id']}}"
                                                                       value="1"
                                                                       class="custom-radio"/>
                                                            @endif
                                                            <span class="icons"><span
                                                                        class="icon-unchecked"></span><span
                                                                        class="icon-checked"></span></span>
                                                            Yes
                                                        </label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="radio-param-no-{{$arg['parameter_id']}}"
                                                               class="radio">
                                                            @if(!array_key_exists($arg['parameter_id'], $data['object']->parameters))
                                                                <input type="radio"
                                                                       name="parameter[{{$arg['parameter_id']}}]"
                                                                       data-toggle="radio"
                                                                       id="radio-param-no-{{$arg['parameter_id']}}"
                                                                       value="0"
                                                                       class="custom-radio" checked/>
                                                            @elseif(array_key_exists($arg['parameter_id'], $data['object']->parameters) && $data['object']->parameters[$arg['parameter_id']] == 0 )
                                                                <input type="radio"
                                                                       name="parameter[{{$arg['parameter_id']}}]"
                                                                       data-toggle="radio"
                                                                       id="radio-param-no-{{$arg['parameter_id']}}"
                                                                       value="0"
                                                                       class="custom-radio" checked/>
                                                            @else
                                                                <input type="radio"
                                                                       name="parameter[{{$arg['parameter_id']}}]"
                                                                       data-toggle="radio"
                                                                       id="radio-param-no-{{$arg['parameter_id']}}"
                                                                       value="0"
                                                                       class="custom-radio"/>
                                                            @endif
                                                            <span class="icons"><span
                                                                        class="icon-unchecked"></span><span
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
                            <input type="hidden" name="object-id" value="{{$data['object']->id}}" />
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