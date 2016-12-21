@extends('layouts.app')

@section('parameter')
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li class="active">Parameters</li>
            </ol>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-1">
                <a class="btn btn-primary" href="{{url('/parameter/add')}}">Add</a>
            </div>
            <div class="col-md-7">
                <div id="parameter-response" class="text-center">
                    @if(Session::has('parameter-search'))
                        <div class="alert alert-success">
                            {{ Session::pull('parameter-search') }}
                        </div>
                    @endif
                    @if(Session::has('parameter-filtering'))
                        <div class="alert alert-success">
                            {{ Session::pull('parameter-filtering') }}
                        </div>
                    @endif

                </div>
            </div>
            <div class="col-md-4">
                <form method="post" action="{{url('/parameter/search')}}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <input name="search" placeholder="Search a parameter..." type="text" class="form-control"
                           id="search-parameter"/>
                </form>
            </div>
        </div>
        <br/>

        <div class="well well-lg clearfix">
            <form role="form" method="post" action="{{url('/parameter/filter')}}">
                <div class="form-group">
                    <div class="col-md-3">
                        <label>Category:</label>
                        <select name="filter-category" class="form-control">
                            @if(isset($data['categories']) && !empty($data['categories']))
                                @foreach($data['categories'] as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Field Type:</label>
                        <select name="filter-type" class="form-control">
                            <option value="All">All</option>
                            <option value="String">String</option>
                            <option value="Boolean">Boolean</option>
                            <option value="Image">Image</option>
                            <option value="Numeric">Numeric</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="search-parameter-filtering" class="checkbox">
                            <input type="checkbox" name="enable-filtering" data-toggle="checkbox"
                                   id="search-parameter-filtering" value="1" class="custom-checkbox">
                                <span class="icons"><span class="icon-unchecked"></span><span
                                            class="icon-checked"></span></span>
                            Enable Filtering
                        </label>
                    </div>
                    <div class="col-md-3">
                        <input type="hidden" name="_token" value="{{csrf_token()}}" />
                        <button type="submit" class="btn btn-success">Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <br/>

        <div class="row">
            <div id="category-container">
                {!! $data['parameters']->render() !!}
                <table class="table table-stripped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mandatory</th>
                        <th>Total Used</th>
                        <th>Type</th>
                        <th>Enable Rating</th>
                        <th>Enable Filtering</th>
                        <th>Enabled</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($data['parameters']) && !empty($data['parameters']))
                        @foreach ($data['parameters'] as $parameter)
                            <tr>
                                <td>{!! $parameter->id !!}</td>
                                <td>{!! $parameter->name !!}</td>
                                <td>
                                    @if($parameter->mandatory == 1)
                                        {!! 'Yes' !!}
                                    @else
                                        {!! 'No' !!}
                                    @endif
                                </td>
                                <td>{!! $parameter->total_used !!}</td>
                                <td>{!! $parameter->field_type!!}</td>
                                <td>
                                    @if($parameter->enable_rating == 1)
                                        {!! 'Yes' !!}
                                    @else
                                        {!! 'No' !!}
                                    @endif
                                </td>
                                <td>
                                    @if($parameter->enable_filtering == 1)
                                        {!! 'Yes' !!}
                                    @else
                                        {!! 'No' !!}
                                    @endif
                                </td>
                                <td>
                                    @if($parameter->disabled == 1)
                                        <label class="checkbox">
                                            <input data-name="{{$parameter->name}}" data-url="{{url('')}}"
                                                   data-csrf="{{csrf_token()}}"
                                                   id="{{ $parameter->id }}" type="checkbox"
                                                   data-toggle="checkbox"
                                                   value="1" class="custom-checkbox enable-disable-parameter"/>
                                            <span class="icons"><span class="icon-unchecked"></span><span
                                                        class="icon-checked"></span></span>
                                        </label>
                                    @else
                                        <label class="checkbox">
                                            <input data-name="{{$parameter->name}}" data-url="{{url('')}}"
                                                   data-csrf="{{csrf_token()}}"
                                                   id="{{ $parameter->id }}" type="checkbox"
                                                   data-toggle="checkbox"
                                                   value="1" class="custom-checkbox enable-disable-parameter"
                                                   checked="checked"/>
                                            <span class="icons"><span class="icon-unchecked"></span><span
                                                        class="icon-checked"></span></span>
                                        </label>
                                    @endif
                                </td>
                                <td>
                                    @if($parameter->mandatory == 1)
                                        {!! 'Edit/Delete manually' !!}
                                    @else
                                        <a href="{{url('/parameter/edit/'.$parameter->id)}}"
                                           class="btn btn-warning btn-xs"><i
                                                    class="fa fa-pencil fa-btn"></i>Edit</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>There is no parameter created yet</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {!! $data['parameters']->links() !!}
                <hr/>
            </div>
        </div>

    </div>
@endsection