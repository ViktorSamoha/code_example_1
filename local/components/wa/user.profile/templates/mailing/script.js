function User(data) {
    this.data = data;
}

User.prototype.componentAjaxAction = function (action, data) {
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
        }
    ).catch(
        function (response) {
        }
    )
}

User.prototype.onSaveChanges = function () {
    let component = this;
    let table = $('#mailing-checkbox-table');
    let saveBtn = $('#save-changes');
    let checkBoxes = table.find('input[type="checkbox"]');
    saveBtn.click(function () {
        let data = [];
        checkBoxes.each(function (index) {
            data[$(this).attr('name')] = this.checked;
        });
        component.componentAjaxAction('updateUserMailing', data);
    });
}

User.prototype.init = function () {
    this.onSaveChanges();
}