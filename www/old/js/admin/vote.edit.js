var voteEditObj = null;
$(document).ready(function(){
  voteEditObj = new VoteEdit();
});

var VoteEdit = function()
{
  this.VoteId = 0;

  this.init();
  this.initInputTitle();

  this.initControls();
  this.initResultControls();

  this.initTinyMCE();

  this.FillMaxQuestions();
  this.FillMaxResult();
}

VoteEdit.prototype.init = function()
{
  var self = this;
  this.VoteId = parseInt($('input[name="vote_id"]').attr('value'), 10);

  $('input.point').live('focus', function(event){
    var element = event.currentTarget;
    var value = parseInt(element.value, 10);
    if ((isNaN(value)) || (value <= 0) )
    {
      element.value = '';
    }
  });
  $('input.point').live('blur', function(event){
    var element = event.currentTarget;
    var value = parseInt(element.value, 10);
    if ((isNaN(value)) || (value <= 0))
    {
      this.value = '0'; 
    }
    self.FillMaxResult();
  });

  $('#button_save').bind('click', function(event){
    $('#form_editvote')[0].submit();
    return false;
  });
}

VoteEdit.prototype.initInputTitle = function()
{
  var input = $('input.title');
  var emptytitle = input.attr('data-empty');

  input.bind('focus', function(event){
    if (event.currentTarget.value == '' || event.currentTarget.value == emptytitle)
    {
      event.currentTarget.style.color = '#000000';
      event.currentTarget.value = '';
    }
  });

  input.bind('blur', function(event){
    if (event.currentTarget.value == '' || event.currentTarget.value == emptytitle)
    {
      event.currentTarget.style.color = '#C0C0C0';
      event.currentTarget.value = emptytitle;
    }
  });

  input.trigger('blur');
}

VoteEdit.prototype.initControls = function()
{
  var self = this;
  $('#base_question a').bind('click', function(event){
    self.AddQuestion(event);
    return false;
  });

  $('.q-delete').live('click', function(event){
    self.DeleteQuestion(event);
    return false;
  });

  $('.answer-add').live('click', function(event){
    self.AddAnswer(event);
    return false;
  });

  $('.answer-delete').live('click', function(event){
    self.DeleteAnswer(event);
    return false;
  });
}

VoteEdit.prototype.initResultControls = function()
{
  var self = this;
  $('.result-add').live('click', function(event){
    self.AddResult(event);
    return false;
  });

  $('.result-delete').live('click', function(event){
    self.DeleteResult(event);
    return false;
  });

  $('.result-end').live('blur', function(event){
    self.CheckMaxResult(event);
  });
}

VoteEdit.prototype.SetQuestionNumbers = function()
{
  $('div.question > h5 > span').each(function(index, element){
    $(element).html(index+1);
  });
}

VoteEdit.prototype.AddQuestion = function(event)
{
  var self = this;
  var question = $('input', $(event.currentTarget).parent()).attr('value');
  $.post('/admin/comission/vote/addquestion/', {
    VoteId: this.VoteId,
    Question: question
  }, function (data){
    self.AddQuestionResponse(data);
  }, 'json');
}

VoteEdit.prototype.AddQuestionResponse = function(data)
{
  if (!data['error'])
  {
    $('#base_question input').attr('value', '');
    $('#base_question').before(data['data']);
    this.SetQuestionNumbers();
    this.FillMaxQuestions();
  }
  else
  {
    alert('Возникла неизвестная ошибка. Попробуйте сохранить тест и обновить страницу.');
  }
}

VoteEdit.prototype.DeleteQuestion = function(event)
{
  var self = this;
  var questionId = $(event.currentTarget).parent().data('id');
  if (confirm('Вы уверены, что хотите удалить вопрос и все его ответы?'))
  {
    $.post('/admin/comission/vote/deletequestion/', {
      VoteId: this.VoteId,
      QuestionId: questionId
    }, function (data){
      self.DeleteQuestionResponse(data);
    }, 'json');
  }
}

VoteEdit.prototype.DeleteQuestionResponse = function(data)
{
  if (!data['error'])
  {
    var id = data['question'];
    $('div.question[data-id="' + id + '"]').remove();
    this.SetQuestionNumbers();
  }
  else
  {
    alert('Возникла неизвестная ошибка. Попробуйте сохранить тест, обновить страницу и повторить.');
  }
}

VoteEdit.prototype.AddAnswer = function(event)
{
  var self = this;
  var questionId = $(event.currentTarget).parent().data('id');
  $.post('/admin/comission/vote/addanswer/', {
    VoteId: this.VoteId,
    QuestionId: questionId
  }, function (data){
    self.AddAnswerResponse(data);
  }, 'json');
}

VoteEdit.prototype.AddAnswerResponse = function(data)
{
  if (!data['error'])
  {
    var id = data['question'];
    $('div.question[data-id="' + id + '"] ol').append(data['data']);
  }
  else
  {
    alert('Возникла неизвестная ошибка. Попробуйте сохранить тест и обновить страницу.');
  }
}

VoteEdit.prototype.DeleteAnswer = function(event)
{
  var self = this;
  var answerId = $(event.currentTarget).parent().data('id');
  $.post('/admin/comission/vote/deleteanswer/', {
    VoteId: this.VoteId,
    AnswerId: answerId
  }, function (data){
    self.DeleteAnswerResponse(data);
  }, 'json');
}

VoteEdit.prototype.DeleteAnswerResponse = function(data)
{
  if (!data['error'])
  {
    var id = data['answer'];
    $('li[data-id="' + id + '"]').remove();
    this.FillMaxResult();
  }
  else
  {
    alert('Возникла неизвестная ошибка. Попробуйте сохранить тест, обновить страницу и повторить.');
  }
}

VoteEdit.prototype.FillMaxQuestions = function()
{
  var questions = $('div.question');
  $('#question_max').html(questions.length - 1);
}

VoteEdit.prototype.FillMaxResult = function()
{
  var questions = $('div.question');
  var sum = 0;
  var max = 0;
  var points = 0;
  questions.each(function(index, element){
    $('ol > li', $(element)).each(function(index2, element2){
      points = $('label > input', $(element2)).attr('value');
      points = parseInt(points, 10);
      if (max < points)
      {
        max = points;
      }
    });
    sum += max;
    max = 0;
  });
  $('#result_max').html(sum);
}

VoteEdit.prototype.AddResult = function(event)
{
  var lastResult = $('.result:last');
  var id = parseInt(lastResult.attr('data-id'), 10);
  var result = lastResult.clone();
  var newId = id+1;
  result.attr('data-id', newId);
  $('input[name="data[result_start][' + id +']"]', result).attr('value', '').attr('name', 'data[result_start][' + newId + ']');
  $('input[name="data[result_end][' + id +']"]', result).attr('value', '').attr('name', 'data[result_end][' + newId + ']');
  $('textarea[name="data[result_description][' + id +']"]', result).empty().attr('name', 'data[result_description][' + newId + ']');
  lastResult.after(result);
}

VoteEdit.prototype.DeleteResult = function(event)
{
  var results = $('div.result');
  if (!(results.length <= 1))
  {
    $(event.currentTarget).parent().remove();
  }
}

VoteEdit.prototype.CheckMaxResult = function(event)
{
  var element = $(event.currentTarget);
  var value = parseInt(element.attr('value'), 10);
  var max = parseInt($('#result_max').html(), 10);
  if (max < value)
  {
    element.attr('value', max);
  }
}

VoteEdit.prototype.initTinyMCE = function()
{
  if (typeof(tinyMCE) != 'undefined')
  {
    tinyMCE.init({
      mode : "specific_textareas",
      editor_selector : "applyTinyMce",
      theme : "advanced",
      language : 'ru',

      // Theme options
      theme_advanced_buttons1 : "bullist,numlist,|,bold,italic",
      theme_advanced_buttons2 : "",
      theme_advanced_buttons3 : "",
      theme_advanced_buttons4 : "",
      theme_advanced_toolbar_location : "top",
      theme_advanced_toolbar_align : "left",
      theme_advanced_statusbar_location : "none",
      theme_advanced_resizing : true,

      //visualisation
      content_css : "/css/tiny_mce.css",

      //Other options
      inline_styles : false
    });
  }
}