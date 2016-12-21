@extends('layouts.app')

@section('settings-content')
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-btn fa-cog"></i>Settings</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-md-12">
                <ul id="settings-tabs" class="nav nav-tabs">
                    <li class="active text-center">
                        <a data-toggle="tab" href="#general-settings">
                            <i class="fa fa-cog fa-btn"></i>
                            General
                        </a>
                    </li>
                    <li class="text-center">
                        <a data-toggle="tab" href="#users-settings">
                            <i class="fa fa-users fa-btn"></i>
                            Users
                        </a>
                    </li>
                    <li class="text-center">
                        <a data-toggle="tab" href="#levels-settings">
                            <i class="fa fa-th-list fa-btn"></i>
                            Levels
                        </a>
                    </li>
                    <li class="text-center">
                        <a data-toggle="tab" href="#reports-settings">
                            <i class="fa fa-folder-open fa-btn"></i>
                            Reports
                        </a>
                    </li>
                    <li class="text-center">
                        <a data-toggle="tab" href="#emails-settings">
                            <i class="fa fa-envelope fa-btn"></i>
                            Emails
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-12">
                <div class="tab-content">
                    @include('admin/settings/general', ['set' => [['settings' => $settings[0]], ['levels' => $settings[5]]]])
                    @include('admin/settings/users', ['set' => [['settings' => $settings[1]]]])
                    @include('admin/settings/levels', ['set' => [['settings' => $settings[2]], ['levels' => $settings[5]]]])
                    @include('admin/settings/reports', ['settings' => $settings[3]])
                    @include('admin/settings/emails', ['settings' => $settings[4]])
                </div>
            </div>
        </div>

        <hr/>
    </div>
@endsection
