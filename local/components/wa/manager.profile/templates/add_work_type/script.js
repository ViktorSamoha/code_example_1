function WorkType(data) {
    this.data = data;
}

WorkType.prototype.componentAjaxAction = function (action, data, form = null) {
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

WorkType.prototype.onWorkTypeCreate = function () {
    let component = this;
    let createBtn = $('#add-work-type');
    let form = $('#form-add-work-type');
    createBtn.click(function (e) {
        e.preventDefault();
        let inputs = form.find('input');
        let data = [];
        inputs.each(function (index) {
            data[$(this).attr('name')] = $(this).val();
        });
        component.componentAjaxAction('addWorkType', data, form);
    });
}

WorkType.prototype.init = function () {
    this.onWorkTypeCreate();
}