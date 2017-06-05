$(function () {
    $('table.table .btn-group .btn-danger').click(function () {
        if (!confirm('Вы точно хотите удалить мероприятие?')) {
            return false;
        }
    })
});
