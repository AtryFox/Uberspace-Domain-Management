function disableModal(days) {
    $('#closeUpdatePanelModal').modal('hide');
    $('#updatePanel').addClass('collapse');

    var date = new Date();
    date.setTime(date.getTime() + (1000 * 60 * 60 * 24 * days));

    document.cookie = "update=-1; expires=" + date.toGMTString() + "; path=/";
}