function User(data) {
    this.data = data;
    console.log(this.data);

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

User.prototype.modalAction = function () {
    let component = this;
    let form = $('#form-edit');
    let btn = form.find('.btn-primary');
    btn.click(function (e) {
        e.preventDefault();
        let input = form.find('input');
        component.componentAjaxAction('updateUserData', {name: input.attr('name'), value: input.val()}, form);
    });
}

User.prototype.onUserDelete = function () {
    let user = this.data;
    let _this = this;
    $('#del-user').click(function (e) {
        e.preventDefault();
        let form = $('#form-edit');
        component.componentAjaxAction('updateUserData', {id: user.ID});
    });
}

User.prototype.onModalOpen = function () {
    let user = this.data;
    let _this = this;
    $('.btn-edit').click(function (e) {
        let btn = e.currentTarget;
        let actionType = $(btn).data('type');
        let form = $('#form-edit');
        switch (actionType) {
            case 'name':
                form.html(`
                <div class="form-item">
                    <label for="user-name" class="label">ФИО</label>
                    <input type="text" name="user-name" class="input input--border-bottom"
                           value="${user.NAME}">
                </div>
                <button class="btn-primary">Сохранить изменения</button>
                `);
                _this.modalAction();
                break;
            case 'company':
                form.html(`
                <div class="form-item">
                    <label for="user-work-company" class="label">Компания</label>
                    <input type="text" name="user-work-company" class="input input--border-bottom"
                           value="${user.WORK_COMPANY}">
                </div>
                <button class="btn-primary">Сохранить изменения</button>
                `);
                _this.modalAction();
                break;
            case 'phone':
                form.html(`
                <div class="form-item">
                    <label for="user-personal-phone" class="label">Телефон</label>
                    <input type="text" name="user-personal-phone" class="input input--border-bottom"
                           value="${user.PERSONAL_PHONE}">
                </div>
                <button class="btn-primary">Сохранить изменения</button>
                `);
                _this.modalAction();
                break;
            case 'email':
                form.html(`
                <div class="form-item">
                    <label for="user-email" class="label">E-mail</label>
                    <input type="text" name="user-email" class="input input--border-bottom"
                           value="${user.EMAIL}">
                </div>
                <button class="btn-primary">Сохранить изменения</button>
                `);
                _this.modalAction();
                break;
            case 'passwd':
                form.html(`
                <div class="form-item">
                    <label for="user-new-pass" class="label">Новый пароль</label>
                    <input type="text" name="user-new-pass" class="input input--border-bottom" value="">
                </div>
                <button class="btn-primary">Сохранить изменения</button>
                `);
                _this.modalAction();
                break;
            case 'telegram':
                form.html(`
                <div class="form-item">
                    <label for="user-telegram" class="label">Ссылка на аккаунт в Telegram</label>
                    <input type="text" name="user-telegram" class="input input--border-bottom" value="">
                </div>
                <button class="btn-primary">Сохранить изменения</button>
                `);
                _this.modalAction();
                break;
            case 'whatsapp':
                form.html(`
                <div class="form-item">
                    <label for="user-whatsapp" class="label">Номер в WhatsApp</label>
                    <input type="text" name="user-whatsapp" class="input input--border-bottom" value="">
                </div>
                <button class="btn-primary">Сохранить изменения</button>
                `);
                _this.modalAction();
                break;
        }
    });
}

User.prototype.buttonActions = function () {
    let filterBtns = $('.filter_btn');
    filterBtns.each(function () {
        $(this).click(function (e) {
            e.preventDefault();
            let btn = $(e.currentTarget);
            let btnAction = btn.attr('data-action');
            filterBtns.each(function () {
                $(this).removeClass('active');
            });
            btn.addClass('active');
            let url = new URL(location.origin + location.pathname);
            switch (btnAction) {
                case 'all':
                    url.searchParams.set('filter', 'N');
                    break;
                case 'wait':
                    url.searchParams.set('filter', 'Y');
                    url.searchParams.set('wait', 'Y');
                    break;
                case 'active':
                    url.searchParams.set('filter', 'Y');
                    url.searchParams.set('active', 'Y');
                    break;
                case 'arch':
                    url.searchParams.set('filter', 'Y');
                    url.searchParams.set('arch', 'Y');
                    break;
            }
            url.searchParams.set('tab', 'tab_03');
            location.href = url;
        });
    });
}

User.prototype.setTabActive = function () {
    let params = new URL(location.href).searchParams;
    for (const [key, value] of params) {
        if (key === 'tab') {
            let tabsHead = $('.tabs-head');
            let tabsBody = $('.tabs-content');
            tabsHead.find('.tabs-head_btn').each(function () {
                $(this).removeClass('active');
            });
            tabsHead.find(`.tabs-head_btn[data-name="${value}"]`).addClass('active');
            tabsBody.find('.tabs-content_item').each(function () {
                $(this).removeClass('active');
            });
            tabsBody.find(`.tabs-content_item[data-name="${value}"]`).addClass('active');
        }
    }
}

User.prototype.onUserPhotoChange = function () {
    let component = this;
    let userPhotoInput = $('#input-user-photo');
    let userPhotoUpdateForm = $('#update-user-photo');
    userPhotoInput.change(function (event) {
        userPhotoUpdateForm.submit();
    });
    userPhotoUpdateForm.on('submit', function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        BX.ajax.runComponentAction(
            'wa:user.profile',
            'saveUserProfilePicture',
            {
                mode: 'class',
                cache: false,
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
            }
        ).then(
            function (response) {
                if (response) {
                    $('#user-photo-msg').html(response.data);
                }
            }
        ).catch(
            function (response) {
                if (response) {
                    $('#user-photo-msg').html(response.data);
                }
            }
        )
    });

}

User.prototype.init = function () {
    this.onModalOpen();
    this.onUserDelete();
    this.buttonActions();
    this.setTabActive();
    this.onUserPhotoChange();
}