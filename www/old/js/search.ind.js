var searchObj = null;
$(document).ready(function() {
  searchObj = new SearchIndex();
});


var SearchIndex = function()
{
  this.LastQuery = '';
  this.RequestNumber = 0;
  this.ResponseNumber = 0;

  this.init();
}

SearchIndex.prototype.init = function()
{
  var self = this;
  $('#search').bind('keydown', function(event){
    self.OnKeyDown(event);
  });

  $(document).bind('click', function(event){
    self.DocumentClick(event);
  });
}

SearchIndex.prototype.OnKeyDown = function(event)
{
  if (event.which == 27)
  {
    this.ResultRemove();
    return;
  }
  setTimeout("searchObj.Change()", 200);
}

SearchIndex.prototype.Change = function()
{
  var self = this;
  var query = $('#search')[0].value;
  if (query.length < 3)
  {
    this.ResultRemove();
    return;
  }
  if (query == this.LastQuery)
  {
    return;
  }
  this.LastQuery = query;
  this.RequestNumber++;
  $.post('/search/ajax/html/', {
    q: query,
    n: self.RequestNumber
  }, function(data){
    self.ChangeResponse(data);
  }, 'json');
}

SearchIndex.prototype.ChangeResponse = function(data)
{
  var number = parseInt(data['number']);
  if (number < this.ResponseNumber)
  {
    return;
  }
  this.RequestNumber = number;
  this.ResultRemove();
  $('#header').prepend($(data['data']));
}

SearchIndex.prototype.DocumentClick = function(event)
{
  var target = $(event.target);
  var id = target.attr('id');
  if (id == 'search')
  {
    return;
  }
  this.ResultRemove();
}

SearchIndex.prototype.ResultRemove = function()
{
  $('#search_result').remove();
}
