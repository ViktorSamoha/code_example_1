function Stages(data) {
    this.data = data;
}

Stages.prototype.onStatusChange = function () {
    let component = this;
    let status_select_observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutationRecord) {
            let selected_value = $(mutationRecord.target).attr('data-selected-id');
            let selected_stage_id = $(mutationRecord.target).attr('data-stage-id');
            ajaxWrap(
                '/ajax/order_status_change.php',
                {
                    status_value: selected_value,
                    stage_id: selected_stage_id,
                    order_id: component.data.ORDER_ID,
                    customer_id: component.data.CUSTOMER,
                    from: component.data.STAGES[selected_stage_id].FROM,
                    to: component.data.STAGES[selected_stage_id].TO,
                }
            ).then(function (result) {
                if (result) {
                    //console.log(result);
                }
            });

        });
    });
    let arSelect = $('.custom-select');
    arSelect.each(function () {
        let status_title = $(this).find('.custom-select_title')[0];
        status_select_observer.observe(status_title, {
            attributes: true,
            attributeFilter: ['data-selected-id']
        });
    });
}

Stages.prototype.onDocInputChange = function () {
    $('#order-doc').on("change", function () {
        $('#upload-order-doc').submit();
    });
    $('#upload-order-doc').on('submit', function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '/ajax/add_order_docs.php',
            type: 'POST',
            cache: false,
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
        }).then(
            function (response) {
                if (response) {
                    $('#order-doc-msg').html(response.responseText);
                }
            }
        ).catch(
            function (response) {
                if (response) {
                    $('#order-doc-msg').html(response.responseText);
                }
            }
        )
    });
}

Stages.prototype.init = function () {
    this.onStatusChange();
    this.onDocInputChange();
}