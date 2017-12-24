/**
 * Created by cemeh666 on 10.12.17.
 */
$( document ).ready(function() {

    $('[data-form-auth]').on("submit", function(e) {
        e.preventDefault();
        sendForm($(this));
        $(this).find('button').attr('disabled','disabled').addClass('disabled');
    });

    $('[data-form-logout]').on("submit", function(e) {
        e.preventDefault();
        sendForm($(this));
        $(this).find('button').attr('disabled','disabled').addClass('disabled');
    });

    $('[data-form-get-category]').on("submit", function(e) {
        e.preventDefault();
        sendForm($(this));
        $(this).find('button').attr('disabled','disabled').addClass('disabled');
    });

    $('[data-form-create-category]').on("submit", function(e) {
        e.preventDefault();
        sendForm($(this));
        $(this).find('button').attr('disabled','disabled').addClass('disabled');
    });

    $('[data-form-edit-category]').on("submit", function(e) {
        e.preventDefault();
        var data_action = $(this).attr('data-action');
        var selected = $(this).find("[name='categories_list']").val();
        $(this).attr('action', data_action+selected);
        sendForm($(this));
        $(this).find('button').attr('disabled','disabled').addClass('disabled');
    });

    $('[data-form-delete-category]').on("submit", function(e) {
        e.preventDefault();
        var data_action = $(this).attr('data-action');
        var selected = $(this).find("[name='categories_list']").val();
        $(this).attr('action', data_action+selected);
        sendForm($(this));
        $(this).find('button').attr('disabled','disabled').addClass('disabled');
    });

    $('[data-form-get-goods]').on("submit", function(e) {
        e.preventDefault();
        var data_action = $(this).attr('data-action');
        var selected = $(this).find("[name='categories_list']").val();
        $(this).attr('action', data_action.replace('{id}', selected));
        sendForm($(this));
        $(this).find('button').attr('disabled','disabled').addClass('disabled');
    });

    $('[data-form-create-goods]').on("submit", function(e) {
        e.preventDefault();
        sendForm($(this));
        $(this).find('button').attr('disabled','disabled').addClass('disabled');
    });

    $('[data-form-edit-goods]').on("submit", function(e) {
        e.preventDefault();
        var data_action = $(this).attr('data-action');
        var selected = $(this).find("[name='goods']").val();
        $(this).attr('action', data_action.replace('{id}', selected));
        sendForm($(this));
        $(this).find('button').attr('disabled','disabled').addClass('disabled');
    });

    $('[data-form-delete-goods]').on("submit", function(e) {
        e.preventDefault();
        var data_action = $(this).attr('data-action');
        var selected = $(this).find("[name='goods']").val();
        $(this).attr('action', data_action.replace('{id}', selected));
        sendForm($(this));
        $(this).find('button').attr('disabled','disabled').addClass('disabled');
    });

    function sendForm($this) {
        var url = $this.attr('action'),
            form = $this,
            data = form.serialize(),
            method = $this.attr('method');

        console.log(url, form, method, data);
        $.ajax({
            type: method,
            url: url,
            data: data,
            dataType: 'json',
            cache: false,
            headers: { 'Authorization': getCookie('api_token') },
            success: function(data) {
                var attr = $(form).attr('data-form-auth');
                var edit_category = $(form).attr('data-form-edit-category');
                var create_category = $(form).attr('data-form-create-category');
                var delete_category = $(form).attr('data-form-delete-category');
                var delete_goods = $(form).attr('data-form-delete-goods');

                if (typeof attr !== typeof undefined && attr !== false && data.status == 'Ok') {
                    setCookie('api_token', data.data.api_token, {expires:365});
                }
                if(typeof create_category !== typeof undefined && create_category !== false && data.status == 'Ok')
                    refreshCategoryList();

                if(typeof delete_category !== typeof undefined && delete_category !== false && data.status == 'Ok')
                    refreshCategoryList();

                if(typeof edit_category !== typeof undefined && edit_category !== false && data.status == 'Ok')
                    refreshCategoryList();

                if(typeof delete_goods !== typeof undefined && delete_goods !== false && data.status == 'Ok')
                    getGoodsList();

                showSuccess(data, form);
                $(form[0]).find('button').removeAttr('disabled').removeClass('disabled');

            },
            error: function (error) {
                showFailed(error, form);
                $(form[0]).find('button').removeAttr('disabled').removeClass('disabled');
                console.log(error);
            }
        });
    }

    function showSuccess(data, form) {
        var inputs = $(form).find('input');
        $.each(inputs, function() {
            $(this).removeClass('error-input');
            $(this).parent().find('.help-block').remove();
        });

        form.parent().parent().find('.json-out').jsonPresenter({
            json: data
        });
        form.parent().parent().find('.collapse').collapse();
    }

    function showFailed(data, form) {
        var inputs = $(form).find('input');
        $.each(inputs, function() {
            $(this).removeClass('error-input');
            $(this).parent().find('.help-block').remove();
        });

        form.parent().parent().find('.json-out').jsonPresenter({
            json: data.responseJSON
        });
        form.parent().parent().find('.collapse').collapse()
    }

});