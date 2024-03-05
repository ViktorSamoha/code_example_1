function User(data) {
    this.data = data;
}

User.prototype.componentAjaxAction = function (action, data, form = null) {
    BX.ajax.runComponentAction(
        'wa:user.profile',
        action,
        {
            mode: 'class',
            dataType: 'json',
            data: data
        }
    ).then(
        function (response) {
            if (response && response.data) {
                if (form) {
                    form.html(`<p>${response.data.msg}</p>`);
                }
            }
        }
    ).catch(
        function (response) {
        }
    )
}

User.prototype.init = function () {

}