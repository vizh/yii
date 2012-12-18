var Vote = null;
$(function(){
  Vote = new VoteModel();
});

var VoteModel = function()
{
  this.depends = new Array();
  this.init();
  this.updateVote();
};

VoteModel.prototype.init = function()
{
  var self = this;

  $('input[type="radio"],input[type="checkbox"]').bind('change', function(){
    self.updateVote();
  });

  $('.question').each(function(index, domElement){
    var depends = eval('(' + $(domElement).attr('data-depends') + ')');
    if (depends.length > 0)
    {
      var obj = new Object();
      obj.QuestionId = $(domElement).attr('data-id');
      obj.Depends = depends;
      self.depends.push(obj);
    }
  });

  $('.question ul.rank li').live('click', function(e){
    self.addRank(e);
    return false;
  });

  $('.question ol.rank span').live('click', function(e){
    self.removeRank(e);
    return false;
  });

  $('.question .custom-input').bind('focusin', function(e){
    self.CustomFocus(e);
  });



};

VoteModel.prototype.updateVote = function()
{
  var self = this;

  var checked = $('input:checked:visible');
  var question;
  var flag;
  var change;
  for (var i=0; i < this.depends.length; i++)
  {
    flag = false;
    for (var j=0; j< this.depends[i].Depends; j++)
    {
      checked.each(function(index, domElement){
        if ($(domElement).attr('value') == self.depends[i].Depends[j])
        {
          flag = true;
        }
      });
    }
    question = $('div.question[data-id="'+this.depends[i].QuestionId+'"]');
    change = flag ? !question.is(':visible') : question.is(':visible');
    if (change)
    {
      if (flag)
      {
        question.show(0);
      }
      else
      {
        question.hide(0);
      }
      checked = $('input:checked:visible');
    }
  }
};

VoteModel.prototype.addRank = function(event)
{
  var target = $(event.currentTarget);
  var name;
  var question = target.parents('.question');
  var removeTag = $('ol.rank > li span', question);
  if (removeTag.length == 0)
  {
    removeTag = $('<span></span>');
  }
  $('ol.rank > li', question).each(function(index, domElement){
    if ($(domElement).attr('data-id') == 'empty')
    {
      name = 'Questions[' + question.attr('data-id') + '][' + target.attr('data-id') + ']';
      $(domElement).append('<input type="hidden" name="' + name + '" value="' + (index+1) + '">');
      $(domElement).append(target.html());
      $(domElement).prepend(removeTag);
      $(domElement).attr('data-id', target.attr('data-id'));
      target.remove();
      return false;
    }
  });
};

VoteModel.prototype.removeRank = function(event)
{
  var target = $(event.currentTarget);
  var question = target.parents('.question');
  var answer = target.parent();
  var prev = answer.prev();
  var removeTag = $('span', answer);
  var last = $('ol.rank > li:last', question);

  if (prev.length != 0)
  {
    prev.prepend(removeTag);
  }
  $('input', answer).remove();

  var li = $('<li></li>');
  li.html(answer.html());
  li.attr('data-id', answer.attr('data-id'));
  answer.attr('data-id', 'empty');
  answer.html('');

  $('ul.rank', question).append(li);
};

VoteModel.prototype.CustomFocus = function(event)
{
  var target = $(event.currentTarget);
  var parent = target.parent();
  var item = $('label input', parent);
  item.prop('checked', true);
};


