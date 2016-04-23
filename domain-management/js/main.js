function disableModal(days) {
    $('#closeUpdatePanelModal').modal('hide');
    $('#updatePanel').addClass('collapse');

    var date = new Date();
    date.setTime(date.getTime() + (1000 * 60 * 60 * 24 * days));
    var expires = "; expires=" + date.toGMTString();

    document.cookie = "update=-1; expires=" + date.toGMTString() + "; path=/";
}