<div class="modal fade" id="user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-danger btn-xs pull-right straight-element" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </button>
                <h6 class="modal-title straight-element" id="myModalLabel">Register New User</h6>
            </div>
            <form method="post" action="" role="form" id="create-edit-user">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name: </label>
                        <input type="text" class="form-control" id="text-name" name="name"
                               value=""/>
                        <span id="user-name-error-message" class="error-message"></span>
                    </div>
                    <div class="form-group">
                        <label>Email: </label>
                        <input type="text" class="form-control" id="url-redirect" name="email"
                               value=""/>
                        <span id="user-email-error-message" class="error-message"></span>
                    </div>
                    <div class="form-group">
                        <label>Password: </label>
                        <input type="password" class="form-control" id="url-redirect" name="password"
                               value=""/>
                        <span id="user-password-error-message" class="error-message"></span>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password: </label>
                        <input type="password" class="form-control" id="url-redirect" name="password_confirmation"
                               value=""/>
                        <span id="user-confirm-password-error-message" class="error-message"></span>
                    </div>
                    <div class="form-group">
                        <label>Select Level: </label>
                        <select id="modal-user-chooser" name="level">
                            @if(isset($modal[0]['levels']['levels']) && !empty($modal[0]['levels']['levels']))
                            @foreach($modal[0]['levels']['levels'] as $level)
                                <option value="{!! $level->id !!}">{!! $level->name !!}</option>
                            @endforeach
                                @endif
                        </select>
                    </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <input type="hidden" name="option" id="hidden-option" value="new"/>
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