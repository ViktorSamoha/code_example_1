function Order(data) {
    this.data = data;
    console.log(this.data);
}

Order.prototype.componentAjaxAction = function (action, data, form = null) {
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
            //TODO:переделать вывод сообщения
            alert(response.data);
        }
    ).catch(
        function (response) {
            //TODO:переделать вывод ошибки
            alert(response.data);
        }
    )
}
Order.prototype.collectFormData = function () {
    let formData = [];
    let stageCount = this.data.STAGE_COUNT;
    for (let i = 1; i <= stageCount; i++) {
        formData[`STAGE_${i}`] = [];
        let workTypeSelect = $(`#work-type-select-stage-${i}`);
        if (workTypeSelect) {
            let wtsValue = workTypeSelect.find('.custom-select_title').attr('data-selected-id');
            formData[`STAGE_${i}`]['TYPE_OF_WORK_ID'] = wtsValue;
        }
        let startDate = $(`#first-input-date-stage-${i}`);
        if (startDate) {
            let sdValue = startDate.val();
            formData[`STAGE_${i}`]['START_DATE'] = sdValue;
        }
        let endDate = $(`#second-input-date-stage-${i}`);
        if (endDate) {
            let edValue = endDate.val();
            formData[`STAGE_${i}`]['END_DATE'] = edValue;
        }
        let stageHlId = $(`#hl-id-stage-${i}`);
        if (stageHlId) {
            let edValue = stageHlId.val();
            formData[`STAGE_${i}`]['RECORD_ID'] = edValue;
        }
    }
    if (formData) {
        return formData;
    } else {
        return false;
    }
}

Order.prototype.onSaveOrderClick = function () {
    let component = this;
    $('#save-order-btn').click(function (e) {
        e.preventDefault();
        let formData = component.collectFormData();
        formData['CUSTOMER'] = $('#customer-select').find('.custom-select_title').attr('data-selected-id');
        formData['EXECUTOR'] = $('#executor-select').find('.custom-select_title').attr('data-selected-id');
        formData['SERVICE_ID'] = $('#service-select').find('.custom-select_title').attr('data-selected-id');
        formData['WAITING_LIST_ELEMENT_ID'] = component.data.WAITING_LIST_ELEMENT_ID;
        formData['ORDER_ID'] = component.data.ORDER_ID;
        formData['STAGE'] = component.data.ORDER_CURRENT_STAGE;
        formData['STATUS'] = component.data.ORDER_STATUS;
        component.componentAjaxAction('saveOrder', formData);
    });
}

Order.prototype.createExecutorSelectNode = function (stageNumber) {
    let html = `<div class="form-item form-item--md">
            <label for="" class="label">Ответственный</label>
            <div class="custom-select" id="executor-select-stage-${stageNumber}"><div class="custom-select_head">
                    <span class="custom-select_title">Выберите ответственного</span>
                    <svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L8 8L15 1" stroke="black"/>
                    </svg>
                </div>
                <div class="custom-select_body">`
    for (const [property_name, property] of Object.entries(this.data.EXECUTOR_LIST)) {
        html += `<div class="custom-select_item" data-id="${property.ID}">${property.LAST_NAME} ${property.NAME} ${property.SECOND_NAME}</div>`;
    }
    html += `</div></div></div>`;
    return html;
}

Order.prototype.createWorkTypeSelectNode = function (stageNumber) {
    let html = `<div class="form-item form-item--md">
            <label for="" class="label">Наименование работ</label>
            <div class="custom-select" id="work-type-select-stage-${stageNumber}">
                <div class="custom-select_head">
                    <span class="custom-select_title">Выберите вид работ</span>
                    <svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L8 8L15 1" stroke="black"/>
                    </svg>
                </div>
                <div class="custom-select_body">`
    for (const [property_name, property] of Object.entries(this.data.WORK_TYPES_LIST)) {
        html += `<div class="custom-select_item" data-id="${property.ID}">${property.NAME}</div>`;
    }
    html += `</div></div></div>`;
    return html;
}

Order.prototype.createStageBlockNode = function (stageNumber) {
    let html = `<h3 class="h3">Этап ${stageNumber}</h3><div class="form-item-group">`;
    html += this.createWorkTypeSelectNode(stageNumber);
    html += `<div class="form-item form-item--md">
            <button class="btn-create-item js-open-modal" data-name="modal-add-type-of-work">
                <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M13.668 6.86914V8.41406H0.0234375V6.86914H13.668ZM7.61133 0.511719V15.0039H5.9707V0.511719H7.61133Z"
                            fill="#DE6396"/>
                </svg>
                <span>Добавить вид работ</span>
            </button>
        </div>
        <div class="form-item">
            <div class="m-input-dates js-input-date-group">
                <div class="m-input-date-block">
                    <label for="" class="input-label">Дата начала</label>
                    <input type="text" class="input-date" id="first-input-date-stage-${stageNumber}">
                </div>
                <div class="m-input-date-block">
                    <label for="" class="input-label">Дата завершения</label>
                    <input type="text" class="input-date second-range-input" id="second-input-date-stage-${stageNumber}">
                </div>
            </div>
        </div>`;

    //html += this.createExecutorSelectNode(stageNumber);

    /*    html += ` <div class="form-item form-item--md">
                <button class="btn-create-item">
                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M13.668 6.86914V8.41406H0.0234375V6.86914H13.668ZM7.61133 0.511719V15.0039H5.9707V0.511719H7.61133Z"
                                fill="#DE6396"/>
                    </svg>
                    <span>Добавить сотрудника</span>
                </button>
            </div></div>`;*/
    return html;
}

Order.prototype.onCreateStageClick = function () {
    let component = this;
    $('#create-stage-btn').click(function (e) {
        e.preventDefault();
        let btn = $(e.currentTarget);
        let stageNumber = parseInt(btn.attr('data-stage-number')) + 1;
        component.data.STAGE_COUNT = stageNumber;
        let html = component.createStageBlockNode(stageNumber);
        //btn.before(html);
        $('#executor-node').before(html);
        //reinitCustomSelect(`#executor-select-stage-${stageNumber}`);
        reinitCustomSelect(`#work-type-select-stage-${stageNumber}`);
        reinitFlatpickr(`#first-input-date-stage-${stageNumber}`,
            `#second-input-date-stage-${stageNumber}`);
        reinitJsOpenModal();
        btn.attr('data-stage-number', stageNumber);
    });
}

Order.prototype.init = function () {
    this.onCreateStageClick();
    this.onSaveOrderClick();
}