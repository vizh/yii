var CProgramGrid = function () {
    this.$widget = $('#event_widgets_ProgramGrid');
    this.isInitialized = false;
}

CProgramGrid.prototype = {
    'init':function () {
        var self = this;

        self.$widget.find('h5').click(function (e) {
            var $target = $(e.currentTarget);
            self.showSectionDetails($target.siblings('.details-text'));
            e.preventDefault();
        });
    },

    'showSectionDetails':function ($section) {
        console.log($section);
        var self = this,
            $modal = $('<div/>', {'class':'modal'});

        $modal.html(
            '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3>' + $section.context.innerText + '</h3></div>' +
            '<div class="modal-body">' + $section[0].innerHTML + '</div>' +
            '<div class="modal-footer"><a href="#" class="btn" data-dismiss="modal">Закрыть</a></div>'
        );
        $modal.on('hidden', function () {
            $modal.remove();
        })
        $modal.modal('show');
    }

}

$(function () {
    var programGrid = new CProgramGrid();

    function initProgramGrid() {
        if (!programGrid.isInitialized && programGrid.$widget.is(':visible')) {
            programGrid.init();
        }
    }

    initProgramGrid();
    $('#event-tabs').on('tabsactivate', function (event, ui) {
        initProgramGrid();
    });
});