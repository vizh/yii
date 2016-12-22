var modalAuthObj = null;
$(function(){
    modalAuthObj = new ModalAuth();
});

var ModalAuth = function() {
    this.modal = $('#ModalAuth');
    this.bootstrapVersion = this.modal.data('bootstrap-version');
    this.src = this.modal.data('src-login');
    this.width = this.modal.data('width') - 20;
    this.height = this.modal.data('height');

    if (this.bootstrapVersion == 3) {
        this.width-=20;
    }

    if (window.location.hash == "#register"){
        this.src = this.modal.data('src-register');
        this.init();
        this.login();
    }
    else{
        this.init();
    }
};
ModalAuth.prototype.init = function() {
    var self = this;

    self.modal.modal({show: false});
    self.modal.on(self.getEventName('show'), function(){
        var top = $(window).scrollTop() + $(window).height() / 10;
        self.modal.css('top', parseInt(top)+'px');
        if (self.bootstrapVersion != 3) {
            self.modal.css('margin-left', '-' + (self.width - 40) / 2 + 'px');
        }

        var prefix = getPrefix();

        var iframe = $('<iframe></iframe>');
        iframe.attr('src', self.src + prefix + 'frame=true');
        iframe.attr('width', self.width);
        iframe.attr('height', self.height);
        iframe.attr('scrolling', 'no');
        iframe.attr('frameborder', 0);
        iframe.on('load', function(event){
            self.iFrameResize(event);
        });

        if (self.bootstrapVersion != 3) {
            self.modal.append(iframe);
        } else {
            self.modal.find('.modal-dialog').append(iframe);
        }
    });


    self.modal.on(self.getEventName('hidden'), function(){
        self.modal.find('iframe').remove();
    });

    $('#NavbarLogin, #PromoLogin').on('click', function(e){
        e.preventDefault();
        self.modal.modal('show');
    });
};
ModalAuth.prototype.success = function() {
    var self = this;
    self.modal.modal('hide');
    window.location.reload();
};
ModalAuth.prototype.iFrameResize = function(event) {
    var target = event.currentTarget;
    $(target).attr('height', target.contentWindow.document.body.offsetHeight);
};
ModalAuth.prototype.getEventName = function (name) {
    var self = this;
    if (this.bootstrapVersion == 3) {
        name += '.bs.modal';
    }
    return name;
};
ModalAuth.prototype.login = function () {
    var href = $('.navbar li.login a').attr('href');
    if (href == '#') {
        this.modal.modal('show');
    } else {
        window.location.href = href;
    }
}


function getPrefix() {
    var url = location.search;
    if (url.indexOf('?') != -1)
    {
        if (window.location.hostname.indexOf('runet-id') != -1)
        {
            return '?';
        }
        return '&';
    }
    else
    {
        return '?';
    }
}