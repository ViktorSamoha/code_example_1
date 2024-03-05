//обертка для аякса
function ajaxWrap(ajax_url, data_object) {
    return $.ajax({
        url: ajax_url,
        method: 'POST',
        data: data_object,
    });
}

//функция отправки формы онлайн записи
function onOnlineRecordFormSubmit() {
    let form = $('#modal-callback-form');
    let submitBtn = form.find('#submit-callback-form');
    submitBtn.click(function (e) {
        e.preventDefault();
        let formData = {};
        formData.USER_FIO = form.find('input[name="USER_FIO"]').val();
        formData.USER_PHONE = form.find('input[name="USER_PHONE"]').val();
        formData.USER_EMAIL = form.find('input[name="USER_EMAIL"]').val();
        formData.USER_QUESTION = form.find('textarea[name="USER_QUESTION"]').val();
        ajaxWrap(
            '/ajax/callback_form.php',
            formData
        ).then(function (result) {
            if (result) {
                let resultData = JSON.parse(result);
                if (resultData.success === true) {
                    form.hide();
                    $('#callback-form-result').html(resultData.msg);
                } else if (resultData.success === false) {
                    form.hide();
                    $('#callback-form-result').html(resultData.msg);
                }
            }
        });
    });
}

//функция отправки формы онлайн записи со страницы услуги
function onGetServiceFormSubmit() {
    let form = $('#get-service-form');
    let submitBtn = form.find('#submit-service-form');
    submitBtn.click(function (e) {
        e.preventDefault();
        let formData = {};
        formData.USER_FIO = form.find('input[name="USER_NAME"]').val();
        formData.USER_EMAIL = form.find('input[name="USER_EMAIL"]').val();
        formData.USER_QUESTION = form.find('input[name="USER_COMMENT"]').val();
        ajaxWrap(
            '/ajax/callback_form.php',
            formData
        ).then(function (result) {
            if (result) {
                let resultData = JSON.parse(result);
                if (resultData.success === true) {
                    form.hide();
                    $('#get-service-form-result').html(resultData.msg);
                } else if (resultData.success === false) {
                    form.hide();
                    $('#get-service-form-result').html(resultData.msg);
                }
            }
        });
    });
}

function reinitCustomSelect(select_selector) {
    let select = document.querySelector(select_selector);
    var closingSortSelect = function closingSortSelect(e) {
        if (!e.composedPath().includes(select)) {
            select.classList.remove('active');
            document.removeEventListener('click', closingSortSelect);
        }
    };
    select.addEventListener('click', function (e) {
        var selectHead = select.querySelector('.custom-select_head');
        var currentOption = this.querySelector('.custom-select_title');

        if (e.composedPath().includes(selectHead)) {
            this.classList.toggle('active');
        }

        if (e.target.classList.contains('custom-select_item')) {
            currentOption.textContent = e.target.textContent;
            currentOption.dataset.selectedId = e.target.dataset.id; //custom

            this.classList.remove('active');
        } //закрытие при клике вне элемента


        if (this.classList.contains('active')) {
            document.addEventListener('click', closingSortSelect);
        } else {
            document.removeEventListener('click', closingSortSelect);
        }
    });
}

function reinitFlatpickr(input_selector, second_input_selector) {
    let input = $(input_selector).get(0);
    let secondInput = $(second_input_selector).get(0);
    flatpickr.localize(flatpickr.l10ns.ru);
    flatpickr(input, {
        dateFormat: "d.m.Y",
        allowInput: "true",
        allowInvalidPreload: true,
        disableMobile: "true",
        minDate: "today",
        "plugins": [new rangePlugin({
            input: secondInput
        })]
    });
}

function reinitJsOpenModal() {
    var openModalBtns = document.querySelectorAll('.js-open-modal');
    var closeModalBtns = document.querySelectorAll('.js-close-modal');
    $(openModalBtns).each(function () {
        $(this).click(function (e) {
            e.preventDefault();
            let _this = e.currentTarget;
            var name = $(_this).attr('data-name');
            var modal = document.querySelector(".modal[data-name='".concat(name, "']"));
            modal.classList.add('active');
        });
    });
    $(closeModalBtns).each(function () {
        $(this).click(function (e) {
            e.preventDefault();
            let _this = e.currentTarget;
            var modal = _this.closest('.modal');
            modal.classList.remove('active');
        });
    });
}

$(document).ready(function () {
    onOnlineRecordFormSubmit();
    onGetServiceFormSubmit();
});