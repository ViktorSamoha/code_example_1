function hideElement(element) {
    let id = $(element).attr('data-item-id');
    ajaxWrap('/ajax/deactivate_element.php', {ID: id});

}