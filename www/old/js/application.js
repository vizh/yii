var AppStatesModel = Backbone.Model.extend({
  });
var appStates = new AppStatesModel();

$(function(){
  window.COverlayView = Backbone.View.extend({
    el: $('#overlay'),
    events: {
      'click': 'HideOverlay'
    },
    initialize: function () { // Подписка на событие модели
      this.model.bind('change:ShowOverlay', this.ChangeOverlay, this);
    },
    ChangeOverlay: function(){
      if (this.model.get('ShowOverlay'))
      {
        this.el.fadeIn(300);
      }
      else
      {
        this.el.fadeOut(0);
      }
    },
    HideOverlay: function(){
      if (this.model.get('ShowOverlay'))
      {
        this.model.set({ShowOverlay: false});
      }
    }
  });
  window.overlayView = new COverlayView({model: appStates});
});