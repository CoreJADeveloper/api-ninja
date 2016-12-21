<div id="control-tab-levels" class="tab-pane">
    {{--<pre>--}}
    {{--{{print_r($set)}}--}}
    {{--</pre>--}}
    <div class="create-new-role">
        <div class="row">
            <div class="col-md-4">
                @if(isset($set[1]['level_settings']['levels_settings']['disable_new_level']['meta_value']) && !$set[1]['level_settings']['levels_settings']['disable_new_level']['meta_value'])
                    <button data-url="{{url('/')}}" data-option="new" class="btn btn-primary"
                            data-backdrop="static"
                            data-keyboard="false" data-toggle="modal" data-target="#user_level_modal">
                        Add
                    </button>
                @endif
            </div>
            <div id="control-level-message" class="col-md-4 text-center">
            </div>
            <div class="col-md-4">
                @if(isset($set[1]['level_settings']['levels_settings']['disable_search']['meta_value']) && !$set[1]['level_settings']['levels_settings']['disable_search']['meta_value'])
                    <input id="search-level-field" type="text" data-csrf="{{csrf_token()}}"
                           data-url="{{url('/')}}" data-characters="{{$set[1]['level_settings']['levels_settings']['search_characters']['meta_value'] or 3}}" class="search-level form-control pull-right"
                           placeholder="Search Level" value="" />
                @endif
            </div>
        </div>
    </div>
    <div id="levels-data-container">
        <b>Please wait content is loading &nbsp; <i class="fa fa-spinner fa-spin"></i></b>
    </div>

</div>