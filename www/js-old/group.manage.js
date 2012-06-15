var MailerSend = function () {
  $('mailerForm').addEvent('submit', function(e) {
   new Event(e).stop();
    var log = $('log').setText('Идет отправка, ждите...');
    this.send({
      update: log
    });
  });
}
var GroupManage = {
  
  _int: function() {
    if ($('cparticipants')) {
      GroupManage.getCurParticipants();
      GroupManage.bindParticipantList();
      GroupManage.bindParticipantCtrl();
    }
    if ($('aparticipants')) GroupManage.getAllParticipants();
  },
  
  getCurParticipants: function() {
    new Ajax('/system/modules/group/ajax.manage.php?action=cparticipants&group=' + $('group').getProperty('alt'), {
      method: 'get',
      update: 'cparticipants'
    }).request();
  },
  
  getAllParticipants: function() {
    new Ajax('/system/modules/group/ajax.manage.php?action=aparticipants', {
      method: 'get',
      update: 'aparticipants'
    }).request();
  },
  
  bindParticipantList: function () {
    $('cparticipants').addEvent('change', function() {
      var values = [];
      $$('#cparticipants option').each(function(option, i) {
        if (option.selected) values.push(option.getProperty('alt'));
      });
      $('control').setProperty('value', values.join(','));
    });
  },
  
  bindParticipantCtrl: function () {
    // Кнопка "Выбрать участников группы"
    $('groups').addEvent('change', function() {
      // ID группы для выборки
      var gid = $('groups').getValue();
      // Получение обновленного списка
      new Ajax('/system/modules/group/ajax.manage.php?action=cparticipants&group=' + gid, {
        method: 'get',
        update: 'aparticipants'
      }).request();
    });
    // Кнопка "Добавить"
    $('add').addEvent('click', function() {
      // rocID для добавления
      var array = $('control').getProperty('value').split(',');
      var value = [];
      // Выборка имеющихся rocID
      $$('#cparticipants option').each(function(option, i) {
        if (option.getProperty('alt') != null) {
          value.push(option.getProperty('alt'));
        }
      });
      // Получение обновленного списка
      new Ajax('/system/modules/group/ajax.manage.php?action=addbyrocid&text=' + value.concat(array), {
        method: 'get',
        update: 'cparticipants'
      }).request();
    });
    // Кнопка "Удалить"
    $('del').addEvent('click', function() {
      $$('#cparticipants option').each(function(option, i) {
        if (option.selected) option.remove();
      });
    });
    // Кнопка "Написать"
    $('mail').addEvent('click', function() {
      var value = [];
      $$('#cparticipants option').each(function(option, i) {
        if (option.selected && option.getProperty('alt') != null) {
          value.push(option.getProperty('value'));
        }
      });
      if (value != '') {
        new Element('div', {'id': 'mailer'}).injectTop($('group'));
        new Ajax('/system/modules/group/ajax.manage.php?action=mail&text=' + value.join(','), {
          method: 'get',
          update: 'mailer',
          onComplete: MailerSend
        }).request();
      } else {
        alert('Выберите хотя бы одного получателя среди участников данной группы!');
      }
    });
    // Кнопка "Копировать"
    $('copy').addEvent('click', function() {
      $$('#aparticipants option').each(function(option, i) {
        if (option.selected) {
          var id = option.getProperty('id');
          var cp = $$('#cparticipants option').filterByAttribute('id', '=', id).length;
          if (cp == 0) option.clone().injectInside('cparticipants').setStyle('color', '#008000');
        }
      });
    });
    // Кнопка "Сохранить"
    $('save').addEvent('click', function() {
      // Временный массив
      var value = [];
      $$('#cparticipants option').each(function(option, i) {
        value.push(option.getProperty('value'));
      });
      // Сохранение
      new Ajax('/system/modules/group/ajax.manage.php?action=save&group=' + $('group').getProperty('alt') + '&text=' + value.join(','), {
        method: 'get',
        update: 'log'
      }).request();
    });
  }

}

window.addEvent('domready', function() {
  GroupManage._int();
});