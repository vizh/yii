$(function(){
  window.CUserBarView = Backbone.View.extend({
    el: $('#userbar'),
    events: {
      'click .loginButton': 'showLogin',
      'click .registerButton': 'showRegister'
    },
    showLogin: function(e){
      e.preventDefault();
      appStates.set({ShowLogin: true});
    },
    showRegister: function(e){
      e.preventDefault();
      appStates.set({ShowRegister: true});
    }
  });

  window.CPopUpLoginView = Backbone.View.extend({
    el: $('#PopUpLogin'),
    events: {
      'click #popup_select_registration': 'showRegister',
      'click #popup_select_login': 'showLogin',
      'click .auth_me': 'AuthMe',
      'click .register_me': 'RegisterMe'
    },
    initialize: function () { // Подписка на событие модели
      this.model.bind('change:ShowLogin', this.ChangeLogin, this);
      this.model.bind('change:ShowRegister', this.ChangeLogin, this);
      this.model.bind('change:ShowOverlay', this.HideWithOverlay, this);
      this.model.bind('change:PopUpRequest', this.ChangeWait, this);

      $('#popup-login-block #AuthForm #password').bind('keypress', function(event){
        if (event.which == '13')
        {
          $('#popup-login-block #AuthForm a.auth_me').trigger('click');
        }
      });
    },

    ChangeLogin: function(){
      if (this.model.get('ShowLogin') || this.model.get('ShowRegister'))
      {
        if (this.model.get('ShowLogin'))
        {
          $('#popup-login-block').removeClass('hide-block');
          $('#popup-registration-block').addClass('hide-block');
        }
        else
        {
          $('#popup-login-block').addClass('hide-block');
          $('#popup-registration-block').removeClass('hide-block');
        }
        this.model.set({ShowOverlay: true});
        var left = ($(window).width() - this.el.width())/2;
        var top = ($(window).height() - this.el.height())/2 + $(window).scrollTop();
        this.el.css({'left': left, 'top': top});
        this.el.fadeIn(500);
      }
      else
      {
        this.el.fadeOut(0);
        this.model.set({ShowOverlay: false});
        $('.notifications').empty();
      }
    },

    HideWithOverlay: function(){
      if (!this.model.get('ShowOverlay'))
      {
        this.Hide();
      }
    },

    Hide: function(){
      if (this.model.get('ShowLogin'))
      {
        this.model.set({ShowLogin: false});
      }
      else if (this.model.get('ShowRegister'))
      {
        this.model.set({ShowRegister: false});
      }
    },

    showLogin: function(e){
      e.preventDefault();
      $('#popup-login-block').removeClass('hide-block');
      $('#popup-registration-block').addClass('hide-block');
    },

    showRegister: function(e){
      e.preventDefault();
      $('#popup-login-block').addClass('hide-block');
      $('#popup-registration-block').removeClass('hide-block');
    },

    AuthMe: function(e){
      var self = this;
      e.preventDefault();
      if (this.model.get('PopUpRequest'))
      {
        return;
      }
      this.model.set({PopUpRequest: true});
      $.post('/main/ajax/login/', $('form[name="AuthForm"]', this.el).serialize(),
        function(data){
          if (!data['error'])
          {
            window.location.reload();
          }
          else
          {
            $('.notifications').empty();
            $('.notifications').append($(data['message']));
          }
          self.model.set({PopUpRequest: false});
        }, 'json');
    },

    RegisterMe: function(e){
      var self = this;
      e.preventDefault();
      if (this.model.get('PopUpRequest'))
      {
        return;
      }
      this.model.set({PopUpRequest: true});
      $.post('/main/ajax/register/', $('form[name="RegForm"]', this.el).serialize(),
        function(data){
          if (!data['error'])
          {
            window.location.reload();
          }
          else
          {
            $('.notifications').empty();
            $('.notifications').append($(data['message']));
          }
          self.model.set({PopUpRequest: false});
        }, 'json');
    },

    ChangeWait: function(){
      if (this.model.get('PopUpRequest'))
      {
        $('.wait', this.el).css('display', 'inline-block');
      }
      else
      {
        $('.wait', this.el).css('display', 'none');
      }
    }
  });
  
  window.UserBarView = new CUserBarView();
  window.PopUpLoginView = new CPopUpLoginView({model: appStates});
});