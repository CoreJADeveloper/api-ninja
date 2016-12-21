<div id="control-tab-users" class="tab-pane active">
    {{--<pre>--}}
    {{--{{print_r($set)}}--}}
    {{--</pre>--}}
    <div class="create-new-role">
        <div class="row">
            <div class="col-md-4">
                @if(isset($set[1]['user_settings']['users_settings']['disable_new_user']['meta_value']) && !$set[1]['user_settings']['users_settings']['disable_new_user']['meta_value'])
                    <button data-url="{{url('/')}}" data-option="new" class="btn btn-primary"
                            data-backdrop="static"
                            data-keyboard="false" data-toggle="modal" data-target="#user_modal">
                        Add
                    </button>
                @endif
            </div>
            <div id="control-user-message" class="col-md-4 text-center">
            </div>
            <div class="col-md-4">
                @if(isset($set[1]['user_settings']['users_settings']['disable_search']['meta_value']) && !$set[1]['user_settings']['users_settings']['disable_search']['meta_value'])
                    <input id="search-user-field" type="text" data-csrf="{{csrf_token()}}"
                           data-url="{{url('/')}}"
                           data-characters="{{$set[1]['user_settings']['users_settings']['search_characters']['meta_value'] or 3}}"
                           class="search-user form-control pull-right"
                           placeholder="Search User" value=""/>
                @endif
            </div>
        </div>
    </div>

    <div id="users-data-container">
        @if(isset($set[2]['users']['users']['selected_users']) && !empty($set[2]['users']['users']['selected_users']))
            {!! $set[2]['users']['users']['pagination'] !!}
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registered Date</th>
                    <th>Last login</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($set[2]['users']['users']['selected_users']->data as $user)
                    <tr>
                        <td>
                            {!! $user->name !!}
                        </td>
                        <td>
                            {!! $user->email !!}
                        </td>
                        <td>
                            {!! $user->created_at !!}
                        </td>
                        <td>
                            {!! $user->last_login !!}
                        </td>
                        <td>
                            <button class="btn btn-primary btn-xs fa-btn"><i class="fa fa-check fa-btn"></i>Edit
                            </button>
                            <button class="btn btn-danger btn-xs"><i class="fa fa-times fa-btn"></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $set[2]['users']['users']['pagination'] !!}
        @else
            <h6>Sorry no registered user yet!</h6>
        @endif
    </div>
</div>