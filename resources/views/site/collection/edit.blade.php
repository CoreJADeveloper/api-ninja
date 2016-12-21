@extends('layouts.app')

@section('collection')
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{url('/collection')}}">Collections</a></li>
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
        @if(Session::has('collection-update'))
            <div class="alert alert-success">
                {{ Session::pull('collection-update') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <form role="form" method="post" action="{{url('/collection/update')}}">
                    <div class="form-group">
                        <label> Collection Name:</label>
                        <input type="text" name="name" value="{!! $data['collection']->name !!}" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label> Unique Code:</label>
                        <input type="text" name="unique_code" value="{!! $data['collection']->unique_code !!}"
                               class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-collection-locked" class="checkbox">
                            @if($data['collection']->locked == 0)
                                <input type="checkbox" name="locked" data-toggle="checkbox"
                                       id="checkbox-collection-locked" value="1" class="custom-checkbox"/>
                            @else
                                <input type="checkbox" name="locked" data-toggle="checkbox"
                                       id="checkbox-collection-locked" value="1" class="custom-checkbox" checked/>
                            @endif
                            <span class="icons"><span class="icon-unchecked"></span><span
                                        class="icon-checked"></span></span>
                            Locked
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-collection-disabled" class="checkbox">
                            @if($data['collection']->disabled == 0)
                                <input type="checkbox" name="disabled" data-toggle="checkbox"
                                       id="checkbox-collection-disabled" value="1" class="custom-checkbox"/>
                            @else
                                <input type="checkbox" name="disabled" data-toggle="checkbox"
                                       id="checkbox-collection-disabled" value="1" class="custom-checkbox" checked/>
                            @endif
                            <span class="icons"><span class="icon-unchecked"></span><span
                                        class="icon-checked"></span></span>
                            Disabled
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Objects</label>
                        <select name="objects[]" data-placeholder="Choose a object..." id="collection-select-objects"
                                class="chosen-select form-control" multiple>
                            @if(isset($data['objects']) && !empty($data['objects']))
                                @foreach($data['objects'] as $object)
                                    @if(in_array($object->id, unserialize($data['collection']->objects)))
                                        <option value="{{$object->id}}" selected>{!! $object->name !!}</option>
                                    @else
                                        <option value="{{$object->id}}">{!! $object->name !!}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="well text-center">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <input type="hidden" name="collection-id" value="{{$data['collection']->id}}" />
                            <a href="{{url('/collection')}}" class="btn btn-danger">Cancel</a>
                            <input type="submit" class="btn btn-success" value="Save"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection