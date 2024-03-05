function Orders(data) {
    this.data = data;
}

Orders.prototype.buttonActions = function () {
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

Orders.prototype.setTabActive = function () {
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

Orders.prototype.init = function () {
    this.buttonActions();
    this.setTabActive();
}