var init = [];
init.push(function () {
    $('.add-tooltip').tooltip();
    $('input[type="file"]').pixelFileInput({
        placeholder: 'Файл не выбран',
        choose_btn_tmpl: '<a href="#" class="btn btn-xs btn-primary">Выбрать</a>',
        clear_btn_tmpl: '<a href="#" class="btn btn-xs"><i class="fa fa-times"></i> Отменить</a>'
    });
});