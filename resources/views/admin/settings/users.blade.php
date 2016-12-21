<div id="users-settings" class="tab-pane">
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-md-offset-4">
            <div id="users-settings-message">
            </div>
        </div>
    </div>
    <form method="post" role="form" id="user-settings-form">
        <div class="form-group">
            <label><b>Total required characters to search a user: <i class="fa fa-question-circle question-sign"
                                                                     title="When user search another user then by default he/she has to enter 3 characters to search a user, you can set any number here to enable searching."></i></b></label>
            <input type="number" class="form-control" name="user-settings[search_characters]"
                   value="{!! $set[0]['settings']['users']['search_characters']['meta_value'] or 3 !!}" min="0"/>
        </div>
        <div class="form-group">
            <label><b>Total users to show in per page: <i class="fa fa-question-circle question-sign"
                                                          title="By default in control panel users tab there would be shown 10 users per page, you can set here any number of users to show in per page."></i></b></label>
            <input type="number" class="form-control" name="user-settings[users_per_page]"
                   value="{!! $set[0]['settings']['users']['users_per_page']['meta_value'] or 10 !!}" min="1"/>
        </div>
        <div class="form-group">
            <label><b>Total users can't be more than: <i class="fa fa-question-circle question-sign"
                                                         title="If you want to register any number of users keep the field value -1 otherwise set how many you want to."></i></b></label>
            <input type="number" class="form-control" name="user-settings[total_users]"
                   value="{!! $set[0]['settings']['users']['total_users']['meta_value'] or -1 !!}" min="-1"/>
        </div>

        <div class="form-group">
            <label for="checkbox-search-option" class="checkbox">
                @if(isset($set[0]['settings']['users']['disable_search']['meta_value']) && $set[0]['settings']['users']['disable_search']['meta_value'])
                    <input type="checkbox" name="user-settings[disable_search]" data-toggle="checkbox"
                           id="checkbox-search-option" value="1"
                           class="custom-checkbox" checked="checked"/>
                @else
                    <input type="checkbox" name="user-settings[disable_search]" data-toggle="checkbox"
                           id="checkbox-search-option" value="1"
                           class="custom-checkbox"/>
                @endif
                <span class="icons"><span class="icon-unchecked"></span>
                    <span class="icon-checked"></span></span>
                Disable search option: <i class="fa fa-question-circle question-sign"
                                          title="By default search option is enabled you can set it disabled here."></i>
            </label>
            <label for="checkbox-disable-new-user" class="checkbox">
                @if(isset($set[0]['settings']['users']['disable_new_user']['meta_value']) && $set[0]['settings']['users']['disable_new_user']['meta_value'])
                    <input type="checkbox" name="user-settings[disable_new_user]" data-toggle="checkbox"
                           id="checkbox-disable-new-user" value="1"
                           class="custom-checkbox" checked="checked"/>
                @else
                    <input type="checkbox" name="user-settings[disable_new_user]" data-toggle="checkbox"
                           id="checkbox-disable-new-user" value="1"
                           class="custom-checkbox"/>
                @endif
                <span class="icons"><span class="icon-unchecked"></span>
                    <span class="icon-checked"></span></span>
                Disable creating new user: <i class="fa fa-question-circle question-sign"
                                              title="By default creating new user is enabled you can set it disable here"></i>
            </label>
            <label for="checkbox-admin-permission" class="checkbox">
                @if(isset($set[0]['settings']['users']['admin_permission']['meta_value']) && $set[0]['settings']['users']['admin_permission']['meta_value'])
                    <input type="checkbox" name="user-settings[admin_permission]" data-toggle="checkbox"
                           id="checkbox-admin-permission" value="1"
                           class="custom-checkbox" checked="checked"/>
                @else
                    <input type="checkbox" name="user-settings[admin_permission]" data-toggle="checkbox"
                           id="checkbox-admin-permission" value="1"
                           class="custom-checkbox"/>
                @endif
                <span class="icons"><span class="icon-unchecked"></span>
                    <span class="icon-checked"></span></span>
                Require admin permission to create a user <i class="fa fa-question-circle question-sign"
                                                             title="If any user create a new user by default it is saved to database without admin permission. By disabling the option, the user needs admin permission to be approved."></i>
            </label>
            <label for="checkbox-users-email-activation" class="checkbox">
                @if(isset($set[0]['settings']['users']['email_activation']['meta_value']) && $set[0]['settings']['users']['email_activation']['meta_value'])
                    <input type="checkbox" name="user-settings[email_activation]" data-toggle="checkbox"
                           id="checkbox-users-email-activation" value="1" class="custom-checkbox" checked="checked"/>
                @else
                    <input type="checkbox" name="user-settings[email_activation]" data-toggle="checkbox"
                           id="checkbox-users-email-activation" value="1" class="custom-checkbox"/>
                @endif
                <span class="icons"><span class="icon-unchecked"></span>
                                            <span class="icon-checked"></span></span>
                Require Email activation for new users <i
                        title="If the option is enabled new registered user need email activation to enable his/her account."
                        class="fa fa-question-circle question-sign"></i>
            </label>
            <label for="checkbox-users-send-mail" class="checkbox">
                @if(isset($set[0]['settings']['users']['send_email']['meta_value']) && $set[0]['settings']['users']['send_email']['meta_value'])
                    <input type="checkbox" name="user-settings[send_email]" data-toggle="checkbox"
                           id="checkbox-users-send-mail" value="1" class="custom-checkbox" checked="checked"/>
                @else
                    <input type="checkbox" name="user-settings[send_email]" data-toggle="checkbox"
                           id="checkbox-users-send-mail" value="1" class="custom-checkbox" />
                @endif

                <span class="icons"><span class="icon-unchecked"></span><span
                            class="icon-checked"></span></span>
                Don't send email when new user registers <i
                        title="If the option is enabled after registering an user no email will be sent to Admin."
                        class="fa fa-question-circle question-sign"></i>
            </label>
        </div>
        <div class="form-group">
            <input type="hidden" id="user-settings-url" value="{{url('/')}}"/>
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            <input type="button" class="btn btn-primary" value="Reset"/>
            <input type="submit" class="btn btn-success" value="Update"/>
        </div>
    </form>
</div>