@extends('layouts.app')

@section('control-panel-content')
    {{--<pre>--}}
    {{--{{print_r($settings)}}--}}
    {{--</pre>--}}
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-btn fa-home"></i>Control Panel</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-md-12"> <!-- required for floating -->
                <ul id="control-panel-tabs" class="nav nav-tabs">
                    <li class="active text-center"><a data-csrf="{{csrf_token()}}" data-href="{{ url('/') }}"
                                                      data-toggle="tab" href="#control-tab-users"><i
                                    class="fa fa-users fa-btn"></i>Users</a></li>
                    <li class="text-center"><a data-csrf="{{csrf_token()}}" data-href="{{ url('/') }}" data-toggle="tab"
                                               href="#control-tab-levels"><i class="fa fa-th-list fa-btn"></i>Levels</a>
                    </li>
                    <li class="text-center"><a data-csrf="{{csrf_token()}}" data-href="{{ url('/') }}" data-toggle="tab"
                                               href="#control-tab-reports"><i class="fa fa-folder-open fa-btn"></i>Reports</a>
                    </li>
                    <li class="text-center"><a data-csrf="{{csrf_token()}}" data-href="{{ url('/') }}" data-toggle="tab"
                                               href="#control-tab-send-emails"><i class="fa fa-envelope fa-btn"></i>Send
                            Emails</a></li>
                    <li class="text-center"><a data-csrf="{{csrf_token()}}" data-href="{{ url('/') }}" data-toggle="tab"
                                               href="#control-tab-settings"><i class="fa fa-cog fa-btn"></i>Settings</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-12">
                <div class="tab-content">
                    @include('admin/control-panel/users', ['set' => [['general_settings' => $settings[0]], ['user_settings' => $settings[1]], ['users' => $settings[5]]]])
                    @include('admin/control-panel/levels', ['set' => [['general_settings' => $settings[0]], ['level_settings' => $settings[2]]]])
                    @include('admin/control-panel/reports')
                    @include('admin/control-panel/emails')

                    <div id="control-tab-settings" class="tab-pane">
                        <b>Please wait &nbsp; <i class="fa fa-spinner fa-spin"></i></b>
                    </div>
                </div>
            </div>
        </div>

        <hr/>
    </div>

    @include('admin/control-panel/add-level', ['level_settings' => $settings[2]])
    @include('admin/control-panel/add-user', ['modal' => [['levels' => $settings[6]], ['user_settings' => $settings[1]]]])
@endsection
