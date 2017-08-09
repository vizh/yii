/**
 * @namespace response.Error.Fields */
/** @namespace response.Error.Message */

Vue.component('ladda', {
    props:{
        id:{default:null},
        type:{default:'btn-default'},
        spinnerColor:{default:'black'}
    },
    template:
        '<button v-on:click="onclick" :id="id" :class="[{btn:true}, type]" data-style="zoom-in" :data-spinner-color="spinnerColor">' +
            '<span class="ladda-label"><slot></slot></span>' +
            '<span class="ladda-spinner"></span>' +
        '</button>',
    created:function(){
        if (this.id === null)
            this.id = 'ladda_' + Math.random().toString(36).substring(2)
        // Выбираем цвет спиннера
        if (this.type !== 'btn-default')
            this.spinnerColor = 'white'
        // Отложенная инициализация
        setTimeout(function(){this.ladda = Ladda.create(document.getElementById(this.id))}.bind(this), 50)
    },
    methods:{
        onclick:function () {
            this.ladda.start()
        }
    }
})

$(function(){
    new Vue({
        el:'#partner-callbacks',
        data:{
            callbacks:[],
            error:null
        },
        created:function(){
            //noinspection JSUnresolvedVariable
            this.callbacks = Callbacks
        },
        methods:{
            reload:function(){
                var app = this
                $.getJSON('?ajaxAction=list', function(response){
                    setTimeout(Ladda.stopAll, 300)
                    if (null === (app.error = response.hasOwnProperty('Error') ? response.Error : null))
                        app.callbacks = response
                })
            },
            save:function(callback){
                var app = this
                $.post('?ajaxAction=update', callback, function(response){
                    response = $.parseJSON(response);
                    if (null === (app.error = response.hasOwnProperty('Error') ? response.Error : null))
                        app.reload()
                    else
                        setTimeout(Ladda.stopAll, 2000)
                })
            }
        }
    })
})