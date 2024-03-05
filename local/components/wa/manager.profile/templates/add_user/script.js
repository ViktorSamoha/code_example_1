function User(data) {
    this.data = data;
}

User.prototype.componentAjaxAction = function (action, data, form = null) {
    BX.ajax.runComponentAction(
        'wa:manager.profile',
        action,
        {
            mode: 'class',
            dataType: 'json',
            data: data
        }
    ).then(
        function (response) {
            if (response && response.data) {
                $('#form-error-msg').html('');
                if (form) {
                    form.html(`<p>${response.data}</p>`);
                }
            }
        }
    ).catch(
        function (response) {
            $('#form-error-msg').html(`<p>${response.data}</p>`);
        }
    )
}

User.prototype.onUserCreate = function () {
    let component = this;
    let createBtn = $(`#${component.data.FORM_BTN_ID}`);
    let form = $(`#${component.data.FORM_ID}`);
    createBtn.click(function (e) {
        e.preventDefault();
        let inputs = form.find('input');
        let data = [];
        inputs.each(function (index) {
            data[$(this).attr('name')] = $(this).val();
        });
        let ddlValue = form.find('.custom-select_title').attr('data-selected-id');
        data['UF_USER_POST'] = ddlValue;
        component.componentAjaxAction('createUser', data, form);
    });
}

User.prototype.init = function () {
    this.onUserCreate();
}