{{--<pre>--}}
{{--{{print_r($level_settings)}}--}}
{{--</pre>--}}
<div class="modal fade" id="user_level_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-danger btn-xs pull-right straight-element" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </button>
                <h6 class="modal-title straight-element" id="myModalLabel">Create user level</h6>
            </div>
            <form method="post" action="" role="form" id="create-edit-level">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name: </label>
                        <input type="text" class="form-control" id="text-name" name="name"
                               value="{name_value}"/>
                        <span id="name-error-message" class="error-message"></span>
                    </div>
                    <div class="form-group">
                        <label>Redirect URL: </label>
                        <input type="url" class="form-control" id="url-redirect" name="form-role[redirect]"
                               value="{!! $level_settings['levels']['redirect_url']['meta_value'] or url('/') !!}"/>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-control-panel" class="checkbox">
                            <input type="checkbox" name="form-role[control-panel]" data-toggle="checkbox"
                                   id="checkbox-control-panel" value="1" class="custom-checkbox">
                                <span class="icons"><span class="icon-unchecked"></span><span
                                            class="icon-checked"></span></span>
                            User can manage control panel
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-categories" class="checkbox">
                            <input type="checkbox" name="form-role[categories]" data-toggle="checkbox"
                                   id="checkbox-categories" value="1" class="custom-checkbox">
                                <span class="icons"><span class="icon-unchecked"></span><span
                                            class="icon-checked"></span></span>
                            User can manage categories
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-parameters" class="checkbox">
                            <input type="checkbox" name="form-role[parameters]" data-toggle="checkbox"
                                   id="checkbox-parameters" value="1" class="custom-checkbox">
                                <span class="icons"><span class="icon-unchecked"></span><span
                                            class="icon-checked"></span></span>
                            User can manage parameters
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-objects" class="checkbox">
                            <input type="checkbox" name="form-role[objects]" data-toggle="checkbox"
                                   id="checkbox-objects" value="1" class="custom-checkbox">
                                <span class="icons"><span class="icon-unchecked"></span><span
                                            class="icon-checked"></span></span>
                            User can manage objects
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-collections" class="checkbox">
                            <input type="checkbox" name="form-role[collections]" data-toggle="checkbox"
                                   id="checkbox-collections" value="1" class="custom-checkbox">
                                <span class="icons"><span class="icon-unchecked"></span><span
                                            class="icon-checked"></span></span>
                            User can manage collections
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="checkbox-categories-collections" class="checkbox">
                            <input type="checkbox" name="form-role[categories-collections]" data-toggle="checkbox"
                                   id="checkbox-categories-collections" value="1"
                                   class="custom-checkbox">
                                <span class="icons"><span class="icon-unchecked"></span><span
                                            class="icon-checked"></span></span>
                            User can manage categories collections
                        </label>
                    </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <input type="hidden" name="form-role[option]" id="hidden-option" value="new"/>
                    <input type="hidden" id="hidden-site-url" value="{{url('/')}}"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>