<div id="levels-settings" class="tab-pane">
    {{--<pre>--}}
    {{--{{print_r($set)}}--}}
    {{--</pre>--}}
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-md-offset-4">
            <div id="levels-settings-message">
            </div>
        </div>
    </div>
    <form method="post" role="form" id="level-settings-form">
        <div class="form-group">
            <label><b>Default New level redirect URL: <i class="fa fa-question-circle question-sign"
                                                         title="When user creates a level there is a redirect URL option, you can set default URL here, otherwise site URL would be selected."></i></b></label>
            <input type="text" class="form-control" name="level-settings[redirect_url]"
                   value="{!! $set[0]['settings']['levels']['redirect_url']['meta_value'] or url('/') !!}"/>
        </div>
        <div class="form-group">
            <label><b>Total required characters to search a level: <i class="fa fa-question-circle question-sign"
                                                                      title="When user search a level then by default he/she has to enter 3 characters to search a level, you can set any number here to enable searching."></i></b></label>
            <input type="number" class="form-control" name="level-settings[search_characters]"
                   value="{!! $set[0]['settings']['levels']['search_characters']['meta_value'] or 3 !!}" min="0"/>
        </div>
        <div class="form-group">
            <label><b>Total levels to show in per page: <i class="fa fa-question-circle question-sign"
                                                           title="By default in control panel levels tab there would be shown 10 levels per page, you can set here any number of levels to show in per page."></i></b></label>
            <input type="number" class="form-control" name="level-settings[levels_per_page]"
                   value="{!! $set[0]['settings']['levels']['levels_per_page']['meta_value'] or 10 !!}" min="1"/>
        </div>
        <div class="form-group">
            <label><b>Total Levels can't be more than: <i class="fa fa-question-circle question-sign"
                                                          title="If you want to create any number of levels keep the field value -1 otherwise set how many you want to."></i></b></label>
            <input type="number" class="form-control" name="level-settings[total_levels]"
                   value="{!! $set[0]['settings']['levels']['total_levels']['meta_value'] or -1 !!}" min="-1"/>
        </div>
        <div class="form-group">
            <label><b>Disable Levels: <i class="fa fa-question-circle question-sign"
                                         title=""></i></b></label>
            <select id="settings-disable-levels" class="chosen-select" data-placeholder="Choose a level" multiple
                    name="level-settings[disabled_levels]">
                @if(isset($set[1]['levels']['levels_information']) && !empty($set[1]['levels']['levels_information']))
                    @foreach($set[1]['levels']['levels_information'] as $level)
                        @if($level->enabled == 0)
                            <option value="{{$level->id}}" selected>{!! $level->name !!}</option>
                        @else
                            <option value="{{$level->id}}">{!! $level->name !!}</option>
                        @endif
                    @endforeach
                @endif
            </select>
        </div>

        <div class="form-group">
            <label for="checkbox-levels-search-option" class="checkbox">
                @if(isset($set[0]['settings']['levels']['disable_search']['meta_value']) && $set[0]['settings']['levels']['disable_search']['meta_value'])
                    <input type="checkbox" name="level-settings[disable_search]" data-toggle="checkbox"
                           id="checkbox-levels-search-option" value="1"
                           class="custom-checkbox" checked="checked"/>
                @else
                    <input type="checkbox" name="level-settings[disable_search]" data-toggle="checkbox"
                           id="checkbox-levels-search-option" value="1"
                           class="custom-checkbox"/>
                @endif
                <span class="icons"><span class="icon-unchecked"></span>
                    <span class="icon-checked"></span></span>
                Disable search option: <i class="fa fa-question-circle question-sign"
                                          title="By default search option is enabled you can set it disabled here."></i>
            </label>
            <label for="checkbox-levels-disable-new-level" class="checkbox">
                @if(isset($set[0]['settings']['levels']['disable_new_level']['meta_value']) && $set[0]['settings']['levels']['disable_new_level']['meta_value'])
                    <input type="checkbox" name="level-settings[disable_new_level]" data-toggle="checkbox"
                           id="checkbox-levels-disable-new-level" value="1"
                           class="custom-checkbox" checked="checked"/>
                @else
                    <input type="checkbox" name="level-settings[disable_new_level]" data-toggle="checkbox"
                           id="checkbox-levels-disable-new-level" value="1"
                           class="custom-checkbox"/>
                @endif
                <span class="icons"><span class="icon-unchecked"></span>
                    <span class="icon-checked"></span></span>
                Disable creating new level: <i class="fa fa-question-circle question-sign"
                                               title="By default creating new level is enabled you can set it disable here"></i>
            </label>
            <label for="checkbox-levels-admin-permission" class="checkbox">
                @if(isset($set[0]['settings']['levels']['admin_permission']['meta_value']) && $set[0]['settings']['levels']['admin_permission']['meta_value'])
                    <input type="checkbox" name="level-settings[admin_permission]" data-toggle="checkbox"
                           id="checkbox-levels-admin-permission" value="1"
                           class="custom-checkbox" checked="checked"/>
                @else
                    <input type="checkbox" name="level-settings[admin_permission]" data-toggle="checkbox"
                           id="checkbox-levels-admin-permission" value="1"
                           class="custom-checkbox"/>
                @endif
                <span class="icons"><span class="icon-unchecked"></span>
                    <span class="icon-checked"></span></span>
                Require admin permission to create a level <i class="fa fa-question-circle question-sign"
                                                              title="If any user create a new level by default it is saved to database without administrator permission. By disabling the option, the level needs administrator permission to be approved."></i>
            </label>
        </div>
        <div class="form-group">
            <input type="hidden" id="level-settings-url" value="{{url('/')}}"/>
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            <input type="button" class="btn btn-primary" value="Reset"/>
            <input type="submit" class="btn btn-success" value="Update"/>
        </div>
    </form>
</div>