function _Post(data) {
    this.data = data;
}

_Post.prototype.componentAjaxAction = function (action, data, form = null) {
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

_Post.prototype.onPostAdd = function () {
    let component = this;
    let createBtn = $('#add-user-post-create');
    let form = $('#form-add-user-post');
    createBtn.click(function (e) {
        e.preventDefault();
        let inputs = form.find('input');
        let data = [];
        inputs.each(function (index) {
            data[$(this).attr('name')] = $(this).val();
        });
        component.componentAjaxAction('addUserPost', data, form);
    });
}

_Post.prototype.init = function () {
    this.onPostAdd();
}