@extends('layouts.app')

@section('collection')
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li class="active">Collections</li>
            </ol>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-1">
                <a class="btn btn-primary customize-left" href="{{url('/collection/add')}}">Add</a>
            </div>
            <div class="col-md-7">
                <div id="collection-response" class="text-center">
                    @if(Session::has('collection-search'))
                        <div class="alert alert-success">
                            {{ Session::pull('collection-search') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <form method="post" action="{{url('/collection/search')}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <input name="search" placeholder="Search a collection..." type="text" class="form-control"
                           id="search-collection"/>
                </form>
            </div>
        </div>
        <br/>

        <div class="row">
            <div id="object-container">
                {!! $data['collections']->render() !!}
                <table class="table table-stripped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Unique Code</th>
                        <th>Security</th>
                        <th>Objects</th>
                        <th>Enabled</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($data['collections']) && !empty($data['collections']))
                        @foreach ($data['collections'] as $collection)
                            <tr>
                                <td>{!! $collection->id !!}</td>
                                <td>{!! $collection->name !!}</td>
                                <td>{!! $collection->unique_code !!}</td>
                                <td>
                                    @if($collection->locked == 1)
                                        {!! 'Locked' !!}
                                    @else
                                        {!! 'Unlocked' !!}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($collection->objects) && $collection->objects != '')
                                        @foreach(unserialize($collection->objects) as $object)
                                            {{$data['objects'][$object].','}}
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if($collection->disabled == 1)
                                        <label class="checkbox">
                                            <input data-name="{{$collection->name}}" data-url="{{url('')}}"
                                                   data-csrf="{{csrf_token()}}"
                                                   id="{{ $collection->id }}" type="checkbox"
                                                   data-toggle="checkbox"
                                                   value="1" class="custom-checkbox enable-disable-collection"/>
                                            <span class="icons"><span class="icon-unchecked"></span><span
                                                        class="icon-checked"></span></span>
                                        </label>
                                    @else
                                        <label class="checkbox">
                                            <input data-name="{{$collection->name}}" data-url="{{url('')}}"
                                                   data-csrf="{{csrf_token()}}"
                                                   id="{{ $collection->id }}" type="checkbox"
                                                   data-toggle="checkbox"
                                                   value="1" class="custom-checkbox enable-disable-collection"
                                                   checked="checked"/>
                                            <span class="icons"><span class="icon-unchecked"></span><span
                                                        class="icon-checked"></span></span>
                                        </label>
                                    @endif
                                </td>
                                <td>
                                    @if($collection->locked == 1)
                                        {!! 'Edit/Delete manually' !!}
                                    @else
                                        <a href="{{url('/collection/edit/'.$collection->id)}}"
                                           class="btn btn-warning btn-xs"><i
                                                    class="fa fa-pencil fa-btn"></i>Edit</a>
                                        <a href="{{url('/collection/delete/'.$collection->id)}}"
                                           class="btn btn-danger btn-xs"><i
                                                    class="fa fa-times fa-btn"></i>Delete</a>

                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>There is no collection created yet</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {!! $data['collections']->links() !!}
            </div>
        </div>
    </div>
@endsection