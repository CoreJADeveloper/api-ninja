/**
 * Created by Tauhid on 4/2/2016.
 */
jQuery(document).ready(function ($) {

    function update_levels_pagination(user_level_url, csrf_token, search_level, confirmation) {
        var confirmation = confirmation;
        $.post(user_level_url, {_token: csrf_token, search: search_level}, function (result) {
            var obj = jQuery.parseJSON(result);
            if (obj.message) {
                $('#levels-data-container').html(obj.code);
                if (confirmation == 'create') {
                    $('#control-level-message').html('<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> Level added successfully!</span></div>');
                }
                if (confirmation == 'tab') {
                    $('#control-level-message').empty();
                }
            } else {
                $('#levels-data-container').html(obj.code);
            }
        });
    }

    function update_users_pagination(user_url, csrf_token, search_user, confirmation) {
        var confirmation = confirmation;
        $.post(user_url, {_token: csrf_token, search: search_user}, function (obj) {
            if (obj.success) {
                $('#control-user-message').empty();
                $('#users-data-container').html(obj.code);
                if (confirmation == 'new') {
                    $('#control-user-message').html('<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> User added successfully!</span></div>');
                }
                if (confirmation == 'search') {
                    $('#control-user-message').empty();
                    $('#users-data-container').empty();
                    $('#users-data-container').html(obj.code);
                }
                if (confirmation == 'tab') {
                    $('#control-user-message').empty();
                    $('#users-data-container').empty();
                    $('#users-data-container').html(obj.code);
                }
            } else {
                $('#users-data-container').html(obj.code);
            }
        });
    }

    function update_category_enable_disable(url, csrf, category_id, category_name, value) {
        $.post(url, {
            _token: csrf,
            category_id: category_id,
            category_name: category_name,
            disabled: value
        }, function (result) {
            $('#category-response').empty();
            $('#category-response').html(result);
            window.location = '#';
        });
    }

    function update_parameter_enable_disable(url, csrf, parameter_id, parameter_name, value){
        $.post(url, {
            _token: csrf,
            parameter_id: parameter_id,
            parameter_name: parameter_name,
            disabled: value
        }, function (result) {
            $('#parameter-response').empty();
            $('#parameter-response').html(result);
            window.location = '#';
        });
    }

    function update_object_enable_disable(url, csrf, object_id, object_name, value){
        $.post(url, {
            _token: csrf,
            object_id: object_id,
            object_name: object_name,
            disabled: value
        }, function (result) {
            $('#object-response').empty();
            $('#object-response').html(result);
            window.location = '#';
        });
    }

    function update_collection_enable_disable(url, csrf, collection_id, collection_name, value){
        $.post(url, {
            _token: csrf,
            collection_id: collection_id,
            collection_name: collection_name,
            disabled: value
        }, function (result) {
            $('#collection-response').empty();
            $('#collection-response').html(result);
            window.location = '#';
        });
    }

    $(document).bind("ajaxSend", function () {
        $("#loading-ajax").removeClass('hide');
    }).bind("ajaxComplete", function () {
        $("#loading-ajax").addClass('hide');
    });

    $('#settings-disable-levels').chosen({width: "100%"});
    $('#general-settings-default-level').chosen({width: "100%"});
    $('#modal-user-chooser').chosen({width: "100%"});
    $('#parameter-categories').chosen({width: "100%"});
    $('#collection-select-objects').chosen({width: "100%"});

    $('#search-level-field').on('input', function (e) {
        var confirmation = 'search';
        var searched_text = $(this).val();
        var all_levels = '';
        var text_length = searched_text.length;
        var url = $(this).data('url');
        var csrf = $(this).data('csrf');
        var characters = $(this).data('characters');
        url = url + '/get-user-levels';
        if (text_length >= characters) {
            update_levels_pagination(url, csrf, searched_text, confirmation);
        } else if (text_length == 0) {
            update_levels_pagination(url, csrf, all_levels, confirmation);
        }
    });

    $('#search-user-field').on('input', function (e) {
        var confirmation = 'search';
        var searched_text = $(this).val();
        var all_users = '';
        var text_length = searched_text.length;
        var url = $(this).data('url');
        var csrf = $(this).data('csrf');
        var characters = $(this).data('characters');
        url = url + '/get-users-pagination';
        if (text_length >= characters) {
            update_users_pagination(url, csrf, searched_text, confirmation);
        } else if (text_length == 0) {
            update_users_pagination(url, csrf, all_users, confirmation);
        }
    });

    $(document).on('shown.bs.tab', '#control-panel-tabs a', function (event) {
        event.preventDefault();
        var current_tab = $(event.target).text();
        var ref_url = $(this).data('href');
        var csrf_token = $(this).data('csrf');
        if (current_tab == 'Levels') {
            $('#search-level-field').val('');
            var user_level_url = ref_url + '/get-user-levels';
            var search_level = '';
            var confirmation = 'tab';
            update_levels_pagination(user_level_url, csrf_token, search_level, confirmation);
        }
        if (current_tab == 'Users') {
            $('#search-level-field').val('');
            var users_pagination_url = ref_url + '/get-users-pagination';
            var search_user = '';
            var confirmation = 'tab';
            update_users_pagination(users_pagination_url, csrf_token, search_user, confirmation);
        }
        if (current_tab == 'Settings') {
            window.location.href = ref_url + '/settings';
        }
    });

    $(document).on('click', '#levels-data-container .user-levels li a', function (event) {
        event.preventDefault();
        //var limit = $(this).data('limit');
        var page = $(this).data('page');
        var url = $(this).data('url');
        var csrf_token = $(this).data('csrf');
        if (!$(this).closest('li').hasClass('disabled')) {
            $.post(url, {_token: csrf_token, page: page}, function (result) {
                var obj = jQuery.parseJSON(result);
                if (obj.message) {
                    $('#levels-data-container').html(obj.code);
                } else {
                    $('#levels-data-container').html(obj.code);
                }
            });
        }
    });

    $(document).on('click', '#users-data-container .users-pagination li a', function (event) {
        event.preventDefault();
        var page = $(this).data('page');
        var url = $(this).data('url');
        var csrf_token = $(this).data('csrf');
        if (!$(this).closest('li').hasClass('disabled')) {
            $.post(url, {_token: csrf_token, page: page}, function (result) {
                if (result.message) {
                    $('#users-data-container').html(result.code);
                } else {
                    $('#users-data-container').html(result.code);
                }
            });
        }
    });

    $('#user_level_modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var option = button.data('option');
        var modal = $(this);
        var url = button.data('url');
        if (option == 'new') {
            modal.find('#text-name').val('');
            //modal.find('#url-redirect').val(url);
            modal.find('#name-error-message').text('');
            modal.find('#create-edit-level input:checkbox').attr('checked', false);
            //$('#checkbox-control-panel').attr('checked', false);
            //$('#checkbox-categories').attr('checked', false);
            //$('#checkbox-parameters').attr('checked', false);
            //$('#checkbox-objects').attr('checked', false);
            //$('#checkbox-collections').attr('checked', false);
            //$('#checkbox-categories-collections').attr('checked', false);
            modal.find('#hidden-option').val('new');
        }
    });

    $('#user_modal').on('show.bs.modal', function (event) {
        $('#user-name-error-message').text('');
        $('#user-email-error-message').text('');
        $('#user-password-error-message').text('');
        $('#user-confirm-password-error-message').text('');
    });

    //$('#user_level_modal').on('hidden.bs.modal', function (event) {
    //    $('#create-edit-level input:checkbox').attr('checked', false);
    //});

    $('#create-edit-level').submit(function () {
        var url = $('#hidden-site-url').val();
        var post_url = url + '/submit-user-level';
        var pagination_url = url + '/get-user-levels';
        $(this).ajaxSubmit({
            url: post_url,
            success: function (result) {
                var obj = jQuery.parseJSON(result);
                if (obj) {
                    if (obj.message == 'success') {
                        $('#user_level_modal').modal('hide');
                        var search_level = '';
                        var confirmation = 'create';
                        update_levels_pagination(pagination_url, obj.csrf, search_level, confirmation);
                    }
                }
            },
            error: function (data) {
                if (data.responseJSON[0]) {
                    var message = data.responseJSON[0];
                    message = message.replace('form-role.name', '');
                    $('#name-error-message').text('* ' + message);
                }
            }
        });
        return false;
    });

    $('#create-edit-user').submit(function () {
        var url = $('#hidden-site-url').val();
        var post_url = url + '/submit-new-user';
        var pagination_url = url + '/get-users';
        $('#user-name-error-message').text('');
        $('#user-email-error-message').text('');
        $('#user-confirm-password-error-message').text('');
        $('#user-password-error-message').text('');
        $(this).ajaxSubmit({
            url: post_url,
            success: function (result) {
                //console.log(result);
                $('#user_modal').modal('hide');
                if (result.success) {
                    var paginate_users_url = url + '/get-users-pagination';
                    var csrf = result.csrf;
                    var users_search = '';
                    var confirmation = 'new';
                    update_users_pagination(paginate_users_url, csrf, users_search, confirmation);
                }
            },
            error: function (data) {
                //var data = JSON.parse(data.responseJSON);
                //console.log(data.responseJSON);
                if (data.responseJSON.name) {
                    var message = data.responseJSON.name;
                    $('#user-name-error-message').text('* ' + message);
                }
                if (data.responseJSON.email) {
                    var message = data.responseJSON.email;
                    $('#user-email-error-message').text('* ' + message);
                }
                if (data.responseJSON.password) {
                    var message = data.responseJSON.password;
                    if (message == 'The password field is required.' || message == 'The password must be at least 6 characters.') {
                        $('#user-password-error-message').text('* ' + message);
                    } else {
                        $('#user-confirm-password-error-message').text('* ' + message);
                    }

                }

            }
        });
        return false;
    });

    $('#level-settings-form').submit(function () {
        var url = $('#level-settings-url').val();
        var post_url = url + '/save-level-settings';
        var disabled_levels = $('#settings-disable-levels').val();
        $(this).ajaxSubmit({
            url: post_url,
            data: {'chosen_disabled_levels': disabled_levels},
            type: 'post',
            success: function (result) {
                if (result && result.message) {
                    $('#levels-settings-message').html('<div class="alert alert-success text-center" role="alert"><i class="fa fa-check"></i> Level settings updated successfully!</span></div>');
                    window.location = '#';
                } else {
                    $('#levels-settings-message').html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-check"></i> Failed to update Level settings!</span></div>');
                    window.location = '#';
                }
            },
            error: function (data) {
                $('#levels-settings-message').html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-times"></i> There is a problem with the action. Please try again!</span></div>');
                window.location = '#';
            }
        });
        return false;
    });

    $('#user-settings-form').submit(function () {
        var url = $('#user-settings-url').val();
        var post_url = url + '/save-user-settings';
        $(this).ajaxSubmit({
            url: post_url,
            type: 'post',
            success: function (result) {
                if (result && result.message) {
                    $('#users-settings-message').html('<div class="alert alert-success text-center" role="alert"><i class="fa fa-check"></i> User settings updated successfully!</span></div>');
                    window.location = '#';
                } else {
                    $('#users-settings-message').html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-check"></i> Failed to update User settings!</span></div>');
                    window.location = '#';
                }
            },
            error: function (data) {
                $('#users-settings-message').html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-times"></i> There is a problem with the action. Please try again!</span></div>');
                window.location = '#';
            }
        });
        return false;
    });

    $('#general-settings-form').submit(function () {
        var url = $('#general-settings-url').val();
        var post_url = url + '/save-general-settings';
        $(this).ajaxSubmit({
            url: post_url,
            type: 'post',
            success: function (result) {
                if (result && result.message) {
                    $('#general-settings-message').html('<div class="alert alert-success text-center" role="alert"><i class="fa fa-check"></i> General settings updated successfully!</span></div>');
                    window.location = '#';
                } else {
                    $('#general-settings-message').html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-check"></i> Failed to update General settings!</span></div>');
                    window.location = '#';
                }
            },
            error: function (data) {
                $('#general-settings-message').html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-times"></i> There is a problem with the action. Please try again!</span></div>');
                window.location = '#';
            }
        });
        return false;
    });

    $('.enable-disable-category').on('change', function (event) {
        event.preventDefault();
        var category_id = $(this).attr('id');
        var url = $(this).data('url');
        url = url + '/category/update/enable-disable';
        var csrf = $(this).data('csrf');
        var category_name = $(this).data('name');
        if ($(this).prop('checked') == true) {
            var value = 0;
            update_category_enable_disable(url, csrf, category_id, category_name, value);
        } else {
            var value = 1;
            update_category_enable_disable(url, csrf, category_id, category_name, value);
        }
    });

    $('.enable-disable-parameter').on('change', function (event) {
        event.preventDefault();
        var parameter_id = $(this).attr('id');
        var url = $(this).data('url');
        url = url + '/parameter/update/enable-disable';
        var csrf = $(this).data('csrf');
        var parameter_name = $(this).data('name');
        if ($(this).prop('checked') == true) {
            var value = 0;
            update_parameter_enable_disable(url, csrf, parameter_id, parameter_name, value);
        } else {
            var value = 1;
            update_parameter_enable_disable(url, csrf, parameter_id, parameter_name, value);
        }
    });

    $('.enable-disable-object').on('change', function (event) {
        event.preventDefault();
        var object_id = $(this).attr('id');
        var url = $(this).data('url');
        url = url + '/object/update/enable-disable';
        var csrf = $(this).data('csrf');
        var object_name = $(this).data('name');
        if ($(this).prop('checked') == true) {
            var value = 0;
            update_object_enable_disable(url, csrf, object_id, object_name, value);
        } else {
            var value = 1;
            update_object_enable_disable(url, csrf, object_id, object_name, value);
        }
    });

    $('.enable-disable-collection').on('change', function (event) {
        event.preventDefault();
        var collection_id = $(this).attr('id');
        var url = $(this).data('url');
        url = url + '/collection/update/enable-disable';
        var csrf = $(this).data('csrf');
        var collection_name = $(this).data('name');
        if ($(this).prop('checked') == true) {
            var value = 0;
            update_collection_enable_disable(url, csrf, collection_id, collection_name, value);
        } else {
            var value = 1;
            update_collection_enable_disable(url, csrf, collection_id, collection_name, value);
        }
    });

    $('#search-category').on('keydown', function (event) {
        if (event.keyCode == 13) {
            this.form.submit();
            return false;
        }
    });

    $('#search-parameter').on('keydown', function (event) {
        if (event.keyCode == 13) {
            this.form.submit();
            return false;
        }
    });

    $('#search-object').on('keydown', function (event) {
        if (event.keyCode == 13) {
            this.form.submit();
            return false;
        }
    });

    $('#search-collection').on('keydown', function (event) {
        if (event.keyCode == 13) {
            this.form.submit();
            return false;
        }
    });

});