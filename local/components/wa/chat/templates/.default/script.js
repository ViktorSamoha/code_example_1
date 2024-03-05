function Chat(data) {
    this.data = data;
    console.log(this.data);
}

Chat.prototype.componentAjaxAction = function (action, data) {
    BX.ajax.runComponentAction(
        'wa:chat',
        action,
        {
            mode: 'class',
            dataType: 'json',
            data: data
        }
    ).then(
        function (response) {
            if (response) {
                if (response.data) {
                    if (response.data.action === "reload") {
                        //TODO:сделать подгрузку аяксом
                    }
                }
            }
        }
    ).catch(
        function (response) {
        }
    )
}

Chat.prototype.onSendMessage = function () {
    let component = this;
    let btn = document.getElementById('send-message');
    btn.onclick = function (e) {
        e.preventDefault();
        let userMessage = document.getElementById('user-message').value;
        component.componentAjaxAction('insertMessage', {
            message: userMessage,
            user_id: component.data.USER.ID,
            order_id: component.data.ORDER_ID,
            manager_id: component.data.MANAGER_ID
        });
    }
}

Chat.prototype.init = function () {
    this.onSendMessage();
}