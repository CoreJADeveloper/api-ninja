@extends('layouts.app')

@section('category')
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li class="active">Objects</li>
            </ol>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-1">
                <a class="btn btn-primary customize-left" href="{{url('/object/add')}}">Add</a>
            </div>
            <div class="col-md-7">
                <div id="object-response" class="text-center">
                    @if(Session::has('object-search'))
                        <div class="alert alert-success">
                            {{ Session::pull('object-search') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <form method="post" action="{{url('/object/search')}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <input name="search" placeholder="Search a object..." type="text" class="form-control" id="search-object"/>
                </form>
            </div>
        </div>
        <br/>

        <div class="row">
            <div id="object-container">
                {!! $data['objects']->render() !!}
                <table class="table table-stripped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Unique Code</th>
                        <th>Security</th>
                        <th>Logo</th>
                        <th>Enabled</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($data['objects']) && !empty($data['objects']))
                        @foreach ($data['objects'] as $object)
                            <tr>
                                <td>{!! $object->id !!}</td>
                                <td>{!! $object->name !!}</td>
                                <td>{!! $object->unique_code !!}</td>
                                <td>
                                    @if($object->locked == 1)
                                        {!! 'Locked' !!}
                                    @else
                                        {!! 'Unlocked' !!}
                                    @endif
                                </td>
                                <td>
                                    <img width="100" height="50" src="{{URL::asset('assets/logo/'.$object->logo)}}" />
                                </td>
                                <td>
                                    @if($object->disabled == 1)
                                        <label class="checkbox">
                                            <input data-name="{{$object->name}}" data-url="{{url('')}}"
                                                   data-csrf="{{csrf_token()}}"
                                                   id="{{ $object->id }}" type="checkbox" name="category[mandatory]"
                                                   data-toggle="checkbox"
                                                   value="1" class="custom-checkbox enable-disable-object"/>
                                            <span class="icons"><span class="icon-unchecked"></span><span
                                                        class="icon-checked"></span></span>
                                        </label>
                                    @else
                                        <label class="checkbox">
                                            <input data-name="{{$object->name}}" data-url="{{url('')}}"
                                                   data-csrf="{{csrf_token()}}"
                                                   id="{{ $object->id }}" type="checkbox" name="category[mandatory]"
                                                   data-toggle="checkbox"
                                                   value="1" class="custom-checkbox enable-disable-object"
                                                   checked="checked"/>
                                            <span class="icons"><span class="icon-unchecked"></span><span
                                                        class="icon-checked"></span></span>
                                        </label>
                                    @endif
                                </td>
                                <td>
                                    @if($object->locked == 1)
                                        {!! 'Edit/Delete manually' !!}
                                    @else
                                        <a href="{{url('/object/edit/'.$object->id)}}"
                                           class="btn btn-warning btn-xs"><i
                                                    class="fa fa-pencil fa-btn"></i>Edit</a>
                                        <a href="{{url('/object/delete/'.$object->id)}}"
                                           class="btn btn-danger btn-xs"><i
                                                    class="fa fa-times fa-btn"></i>Delete</a>

                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>There is no object created yet</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {!! $data['objects']->links() !!}
            </div>
        </div>
    </div>
@endsection