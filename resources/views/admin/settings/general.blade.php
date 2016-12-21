<div id="general-settings" class="tab-pane active">
    {{--<pre>--}}
        {{--{{print_r($set)}}--}}
    {{--</pre>--}}
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-md-offset-4">
            <div id="general-settings-message">
            </div>
        </div>
    </div>
    <div id="general-settings-container">
        <form role="form" method="post" id="general-settings-form">
            <div class="form-group">
                <label>Admin Email Address: <i title="The email address would be used to send all emails."
                                               class="fa fa-question-circle question-sign"></i></label>
                <input type="email" class="form-control" name="general-settings[admin_email]"
                       value="{!! $set[0]['settings']['general']['admin_email']['meta_value'] or '' !!}"/>
            </div>
            <div class="form-group">
                <label>Default Session: <i
                            title="Keep it -1 if you want to stay user logged-in until session is closed, otherwise add time in minutes to keep user logged-in."
                            class="fa fa-question-circle question-sign"></i></label>
                <input type="number" class="form-control" min="-1" name="general-settings[default_session]"
                       value="{!! $set[0]['settings']['general']['default_session']['meta_value'] or -1 !!}"/>
            </div>
            <div class="form-group">
                <label>Custom CSS: <i title="If you want to add some custom CSS, add CSS code here."
                                      class="fa fa-question-circle question-sign"></i></label>
                <textarea class="form-control" cols="10" name="general-settings[custom_css]">{!! $set[0]['settings']['general']['custom_css']['meta_value'] or '' !!}</textarea>
            </div>
            <div class="form-group">
                <label for="general-settings-default-level">New registered(from front-end) user level: <i
                            title="When new user registered from front-end the default level of the user can be selected here."
                            class="fa fa-question-circle question-sign"></i></label>
                <select id="general-settings-default-level" class="chosen-select"
                        data-placeholder="Choose default new user level"
                        name="general-settings[default_level]">
                    @if(isset($set[1]['levels']['levels_information']) && !empty($set[1]['levels']['levels_information']))
                        @foreach($set[1]['levels']['levels_information'] as $level)
                            @if($level->id == $set[0]['settings']['general']['default_level']['meta_value'])
                                <option value="{{$level->id}}" selected>{!! $level->name !!}</option>
                            @else
                                <option value="{{$level->id}}">{!! $level->name !!}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="checkbox-general-disable-registration" class="checkbox">
                    @if(isset($set[0]['settings']['general']['disable_registration']['meta_value']) && $set[0]['settings']['general']['disable_registration']['meta_value'])
                        <input type="checkbox" name="general-settings[disable_registration]" data-toggle="checkbox"
                               id="checkbox-general-disable-registration" value="1" class="custom-checkbox"
                               checked="checked"/>
                    @else
                        <input type="checkbox" name="general-settings[disable_registration]" data-toggle="checkbox"
                               id="checkbox-general-disable-registration" value="1" class="custom-checkbox"/>
                    @endif
                    <span class="icons"><span class="icon-unchecked"></span>
                                            <span class="icon-checked"></span></span>
                    Disable Registration <i title="You can disable registration of new users using this option"
                                            class="fa fa-question-circle question-sign"></i>
                </label>
                <label for="checkbox-general-disable-login" class="checkbox">
                    @if(isset($set[0]['settings']['general']['disable_login']['meta_value']) && $set[0]['settings']['general']['disable_login']['meta_value'])
                        <input type="checkbox" name="general-settings[disable_login]" data-toggle="checkbox"
                               id="checkbox-general-disable-login" value="1" class="custom-checkbox" checked="checked"/>
                    @else
                        <input type="checkbox" name="general-settings[disable_login]" data-toggle="checkbox"
                               id="checkbox-general-disable-login" value="1" class="custom-checkbox"/>
                    @endif
                    <span class="icons"><span class="icon-unchecked"></span><span
                                class="icon-checked"></span></span>
                    Disable Login <i title="You can disable login to the site."
                                     class="fa fa-question-circle question-sign"></i>
                </label>
                <label for="checkbox-general-enable-recaptcha" class="checkbox">
                    @if(isset($set[0]['settings']['general']['enable_recaptcha']['meta_value']) && $set[0]['settings']['general']['enable_recaptcha']['meta_value'])
                    <input type="checkbox" name="general-settings[enable_recaptcha]" data-toggle="checkbox"
                           id="checkbox-general-enable-recaptcha" value="1" class="custom-checkbox" checked="checked"/>
                    @else
                        <input type="checkbox" name="general-settings[enable_recaptcha]" data-toggle="checkbox"
                               id="checkbox-general-enable-recaptcha" value="1" class="custom-checkbox"/>
                    @endif
                                        <span class="icons"><span class="icon-unchecked"></span><span
                                                    class="icon-checked"></span></span>
                    Enable reCAPTCHA <i title="You can enable reCAPTCHA option here."
                                        class="fa fa-question-circle question-sign"></i>
                </label>
            </div>
            <div class="form-group">
                <input type="hidden" id="general-settings-url" value="{{url('/')}}"/>
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <input type="button" class="btn btn-primary" value="Reset"/>
                <input type="submit" class="btn btn-success" value="Update"/>
            </div>
        </form>
    </div>
</div>