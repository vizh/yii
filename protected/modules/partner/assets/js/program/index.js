$(function () {
  var CProgramGrid = function () {
    this.table = $('table.table');
    this.sections = $('div.section');
    this.initSections();
  };
  CProgramGrid.prototype = {
    initSections: function () {
      var self = this;
      self.sections.each(function () {
        var cell1  = self.getCell($(this).data('time-start'), $(this).data('hall-start'));
        var cell2  = self.getCell($(this).data('time-end'), $(this).data('hall-end'));
        var width  = cell2.position().left - cell1.position().left + cell2.outerWidth() - ($(this).outerWidth() - $(this).width()),
            height = cell2.position().top - cell1.position().top - ($(this).outerHeight() - $(this).height());
        $(this).css({
          'top'  : cell1.position().top+'px',
          'left' : cell1.position().left+'px',
          'width' : width+'px',
          'height' : height+'px',
          'overflow' : 'hidden',
          'position' : 'absolute'
        });
      });
    },
            
    getCell: function (time, hall) {
      var self = this,
          row  = self.table.find('td[data-time="'+time+'"]').parent('tr');
      return row.find('td[data-hall-id="'+hall+'"]');
    }
  }
  
  var programGrid = new CProgramGrid();
});