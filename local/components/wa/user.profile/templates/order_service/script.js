function ServiceForm(data) {
    this.data = data;
    //console.log(this.data);
}

ServiceForm.prototype.componentAjaxAction = function (action, data) {
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
            //console.log(response);
            $('#form-success-msg').after(response.data);
        }
    ).catch(
        function (response) {
            //console.log(response);
            if (response.status === 'error') {
                $('#form-error-msg').html(response.data);
            }
        }
    )
}

ServiceForm.prototype.confirmOrder = function () {
    let orderBtn = $('#confirm-order');
    let component = this;
    orderBtn.click(function (e) {
        e.preventDefault();
        let service_id = $('#service-list').find('.custom-select_title').attr('data-selected-id');
        if (typeof service_id !== "undefined" || service_id !== '') {
            component.componentAjaxAction('orderService', {
                service_id: service_id,
                user_id: component.data.ID,
                user_company_name: component.data.WORK_COMPANY,
            });
        }
    });
}

ServiceForm.prototype.init = function () {
    this.confirmOrder();
}