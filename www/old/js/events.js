var eventObj = null;
$(document).ready(
  function()
  {
    eventObj = new EventList();
    setInterval("eventObj.hashChangeEvent()", 50);
  }
);

/*
|---------------------------------------------------------------
| Работа с календарем/списком мероприятий
|---------------------------------------------------------------
*/   
var EventList = function ()
{
  this.active = 'l'; //l - List  or c - Calendar
  this.year = this.DefaultYear = parseInt($('#calendar-ch-year').attr('data-default'));
  this.month = this.DefaultMonth = parseInt($('#calendar-ch-month').attr('data-default'));

  this.MinYear = parseInt($('#datepicker-year a:first').attr('id'));
  this.MaxYear = parseInt($('#datepicker-year a:last').attr('id'));

  this.isRequest = false;
  this.ShowType = null;

  this.Hash = '';
  
  this.popUpDayId = '#popup-day-info';
  this.popUpEventId = '#popup-event-info';
  
  this.init();
  this.initListEvents();
  this.initCalendarEvents();
}

EventList.prototype.init = function()
{
  var self = this;

  if ($('#ActivateList')) 
  {
    $('#ActivateList').bind('click', function (){
      return self.ChangeView(this);
    });
  }
  
  if ($('#ActivateCalendar')) 
  {
    $('#ActivateCalendar').bind('click', function (){
      return self.ChangeView(this);
    });
  }
  
  $('.calendar-choose a:visible').bind('click', function(){
    self.ShowChoose(this);
    return false;    
  });
  
  $('body').bind('click', function(){
    self.HideChoose();
    return true;
  })
  $('#datepicker-year a').bind('click', function(){
    self.SelectYear(this);
    return false;
  });
  $('#datepicker-month a').bind('click', function(){
    self.SelectMonth(this);
    return false;
  });

  $('#event3-paginator a').unbind();
  $('#event3-paginator a').bind('click', function(event){
    self.ChangeMonth(event);
    return false;
  });  
};

EventList.prototype.initHref = function()
{
  if (this.Hash != '')
  {
    var parts = this.Hash.split('-');
    if (parts.length != 3)
    {
      this.updateHash(this.active, this.DefaultYear, this.DefaultMonth);
      return;
    }
    var error = false;
    switch (parts[0]){
      case 'l':
        this.active = 'l';
        break;
      case 'c':
        this.active = 'c';
        break;
      default:
        error = true;
    }
    var year = parseInt(parts[1]);
    if (year < this.MinYear)
    {
      year = this.MinYear;
      error = true;
    }
    else if (year > this.MaxYear)
    {
      year = this.MaxYear;
      error = true;
    }
    else
    {
      this.year = year;
      $('#year-val').html(year);
    }

    var month = parseInt(parts[2]);
    if (month < 1)
    {
      month = 1;
      error = true;
    }
    else if (month > 12)
    {
      month = 12;
      error = true;
    }
    else
    {
      this.month = month;
      var monthTitle = $('#datepicker-month a#' + month).html();
      $('#month-val').html(monthTitle);
    }

    if (error)
    {
      this.updateHash(this.active, year, month);
      return false;
    }
  }
  else
  {
    this.active = 'l';
    this.year = this.DefaultYear;
    this.month = this.DefaultMonth
  }

  this.GetContent();
}

EventList.prototype.hashChangeEvent = function()
{
  var newHash = location.hash.split('#');
  if (newHash.length == 1)
  {
    newHash[1] = '';
  }
  if (newHash[1] != this.Hash)
  {
    this.Hash = newHash[1];
    this.initHref();
  }
};

EventList.prototype.updateHash = function(active, year, month)
{
  window.location.hash = '#' + (active != null ? active : this.active) + '-'
    + (year != null ? year : this.year) + '-' + (month != null ? month : this.month);
};

EventList.prototype.initListEvents = function()
{
  var self = this;
  
  $('a.allevents').live('click', function(event){
    self.ShowHideAllEvents(event);
    return false;
  });

  if ($('a.allevents').length != 0)
  {
    $('#PrevEvents .event3-item').css('display', 'none');
    $('#PrevEvents .event3-item:first').css('display', 'block');
  }  
}

EventList.prototype.initCalendarEvents = function()
{
  var self = this;
  $('#calendar-tbl td').live('mouseenter', function(event){
    if (self.ShowType == null)
    {
      self.ShowType = 'enter';
      self.ShowAllDayEvents(event);
    }
    return false;
  });

  $('#calendar-tbl td').live('mouseleave', function(event){
    if (self.ShowType == 'enter')
    {
      self.ShowType = null;
      self.HideAllDayEvents();
    }
    return false;
  });

  $('#calendar-tbl td').live('click', function(event){
    if (self.ShowType == null)
    {
      self.ShowType = 'click';
      self.ShowAllDayEvents(event);
    }
  });

  $('body').bind('click', function(event){
    if (self.ShowType == 'click')
    {
      self.ShowType = null;
      self.HideAllDayEvents();
    }
  });

  $('#calendar-tbl a.event-details').live('click', function(event){
    if (self.ShowType == null)
    {
      self.ShowType = 'click';
      var element = $(event.currentTarget).parent().parent().parent();
      $('div.hidden-events', element).show(0);
    }
    return false;
  });
}

EventList.prototype.ChangeView = function(e)
{  
  if (this.isRequest)
  {
    return false;
  }

  if (e.id == 'ActivateList' && this.active != 'l')
  {
    this.updateHash('l', null, null);
  }
  else if (e.id == 'ActivateCalendar' && this.active != 'c')
  {
    this.updateHash('c', null, null);
  }
  return false;
}

EventList.prototype.GetContent = function()
{
  var self = this;
  this.isRequest = true;

  if (this.active == 'c')
  {
    if ($('#ActivateList').hasClass('this'))
    {
      $('#ActivateList').removeClass('this');
      $('#ActivateList').addClass('ln');
      $('#ActivateCalendar').addClass('this');
      $('#ActivateCalendar').removeClass('ln');
    }
    $.get('/event/calendar/' + this.year + '/' + this.month, function (data){
      self.ResponseViewCalendar(data);
    });
  }

  if (this.active == 'l')
  {
    if ($('#ActivateCalendar').hasClass('this'))
    {
      $('#ActivateCalendar').removeClass('this');
      $('#ActivateCalendar').addClass('ln');
      $('#ActivateList').addClass('this');
      $('#ActivateList').removeClass('ln');
    }
    $.get('/event/main/' + this.year + '/' + this.month, function (data){
      self.ResponseViewList(data);
    });
  }
}

EventList.prototype.ResponseViewCalendar = function(data)
{
  this.isRequest = false;
  var self = this;
  $('#calendar-list').css('display', 'none');
  $('#sidebar').css('display', 'none');
  $('#calendar-body').css('display', 'block');

  $('#calendar-day > p').unbind();
  $('.show_all_day').unbind();
  $('#calendar-body').empty();
  $('#calendar-body').append(data);
  $('#calendar-day > p').bind('click', function(){
    self.HidePopUpAllDay(this);
    self.ShowPopUpInfo(this);
  });
  $('.show_all_day').bind('click', function(){
    self.HidePopUpInfo(this);
    self.ShowPopUpAllDay(this);
    return false;
  });
  
  var popupEvent = $(this.popUpEventId);
  popupEvent.bind('click', function(){
    self.HidePopUpInfo();
    return true;
  });
  popupEvent.hide();
  
  var popupDay = $(this.popUpDayId);
  popupDay.bind('click', function(){
    self.HidePopUpAllDay();
    return true;
  });
  popupDay.hide();
}

EventList.prototype.ResponseViewList = function(data)
{
  this.isRequest = false;
  var self = this;
  $('#calendar-body').css('display', 'none');

  $('#calendar-list').css('display', 'block');
  $('#sidebar').css('display', 'block');
  $('#calendar-list').empty();
  data = $(data);
  $('#PrevEvents .event3-item', data).css('display', 'none');
  $('#PrevEvents .event3-item:first', data).css('display', 'block');
  $('#calendar-list').append(data);

  $('#event3-paginator a').unbind();
  $('#event3-paginator a').bind('click', function(event){
    self.ChangeMonth(event);
    return false;
  });
}

/**
 *
 */
EventList.prototype.ShowHideAllEvents = function(event)
{
  var element = $(event.currentTarget);
  if (element.hasClass('hide-events'))
  {
    $('#PrevEvents .event3-item').css('display', 'none');
    $('#PrevEvents .event3-item:first').css('display', 'block');
    element.removeClass('hide-events');
    $('span[data-role="show"]', element).removeClass('hide');
    $('span[data-role="hide"]', element).addClass('hide');
  }
  else
  {
    $('#PrevEvents .event3-item').css('display', 'block');
    element.addClass('hide-events');
    $('span[data-role="hide"]', element).removeClass('hide');
    $('span[data-role="show"]', element).addClass('hide');
  }
}

EventList.prototype.ShowAllDayEvents = function(event)
{
  var element = $(event.currentTarget);
  $('div.hidden-events', element).show(0);
}

EventList.prototype.HideAllDayEvents = function()
{
  $('div.hidden-events').hide(0);
}

/**
* Выводит всплывающую подсказку для мероприятий, отображаемых в календаре
*/
EventList.prototype.ShowPopUpInfo = function(e)
{
  var parent = $(e.parentNode);
  var div = $(this.popUpEventId);
  div.hide();
  div.empty();
  var divContent = e.innerHTML + '<ul><li><a href="#' + e.id + '">принять участие</a></li><li><a href="#' + e.id + '">добавить в календарь</a></li></ul>';
  div.append(divContent);
  div.prependTo(parent);
  div.css('top', $(e).offset().top - 5);
  div.show();  
}

EventList.prototype.HidePopUpInfo = function(e)
{
  $(this.popUpEventId).hide();
}

EventList.prototype.ShowPopUpAllDay = function(e)
{
  var self = this;
  var parent = $(e.parentNode);
  var div = $(this.popUpDayId);
  div.hide();
  $('p', div).unbind();
  div.empty();
  var content = parent.html();
  div.append(content);
  $('p', div).show();
  $('.d', div).removeClass('calendar_event_pointer');  
  //$('.d', div).css('padding-top', 0);
  $('a', div).remove();
  $(this.popUpEventId, div).remove();
  $('p', div).bind('click', function(){
    self.HidePopUpAllDay(this);
    self.ShowPopUpInfo2(this);
  });
  div.prependTo(parent);
  div.show();
}

EventList.prototype.HidePopUpAllDay = function(e)
{
  $(this.popUpDayId).hide();
}
/**
* Выводит всплывающую подсказку для мероприятий, скрытых из за большого их количества
*/
EventList.prototype.ShowPopUpInfo2 = function(e)
{
  var parent_day = $(e.parentNode.parentNode);
  var div = $(this.popUpEventId);
  var id = e.id;
  e.id = '';  
  div.hide();
  div.empty();
  var divContent = e.innerHTML + '<ul><li><a href="#' + e.id + '">принять участие</a></li><li><a href="#' + e.id + '">добавить в календарь</a></li></ul>';
  div.append(divContent);
  div.prependTo(parent_day);
  
  var showEvent = $('#' + id, parent_day);
  var offsetTop = 0;
  if (showEvent.hasClass('calendar_event_hide'))
  {
    offsetTop = $('p:visible', parent_day).offset().top;
  }
  else
  {
    offsetTop = showEvent.offset().top;
  }  
  div.css('top', offsetTop - 5);
  div.show();  
}


EventList.prototype.ShowChoose = function(e)
{
  var parent = $(e.parentNode);
  $('div', parent).show();
}

EventList.prototype.HideChoose = function()
{
  $('#datepicker-year').hide();
  $('#datepicker-month').hide();
}

EventList.prototype.SelectYear = function(e)
{
  this.updateHash(null, e.id, null);
  this.HideChoose();

//  var id = e.id;
//  $('#year-val').attr('year', id);
//  $('#year-val').html(id);
//  this.HideChoose();
//  this.GetContent();
}

EventList.prototype.SelectMonth = function(e)
{
  this.updateHash(null, null, e.id);
  this.HideChoose();
//  var id = e.id;
//  $('#month-val').attr('month', id);
//  $('#month-val').html(e.innerHTML);
//  this.HideChoose();
//  this.GetContent();
}

EventList.prototype.ChangeMonth = function(event)
{
  if (this.isRequest)
  {
    return;
  }
  var element = $(event.currentTarget);
  var id = element.attr('id');

  var year = this.year;
  var month = this.month;

  if (id == 'be3p')
  {
    if (month == 1)
    {
      month = 12;
      year -= 1;
      if (year < this.MinYear)
      {
        year = this.MinYear;
        month = 1;
      }
    }
    else
    {
      month -= 1;
    }
  }
  if (id == 'fe3p')
  {
    if (month == 12)
    {
      month = 1;
      year += 1;
      if (year > this.MaxYear)
      {
        year = this.MaxYear;
        month = 12;
      }
    }
    else
    {
      month += 1;
    }
  }

  this.updateHash(null, year, month);
//  $('#year-val').html(year);
//  $('#year-val').attr('year', year);
//
//  var monthTitle = $('#datepicker-month a#' + month).html();
//  $('#month-val').html(monthTitle);
//  $('#month-val').attr('month', month);
//  this.GetContent();
};
