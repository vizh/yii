$(function () {
    /* USER ACCOUNT */
    /* User account -> Participated */
    var participatedYearSelector = $('.user-account #participationYears');

    if (participatedYearSelector) {
        // Current year
        var currentYear = new Date().getFullYear();
        // Set current year on load
        participatedYearSelector.val(currentYear);
        // Rebuild grid on change
        participatedYearSelector.change(function (e) {
            var year = $(e.currentTarget).val();
            var figures = $('.b-participated .row figure');
            if (year == 0) {
                figures.show();
            } else {
                figures.hide();
                figures.filter('[data-year="' + year + '"]').show();
            }
        });
        // Simulate year selection
        participatedYearSelector.trigger('change');
        // Show all participations
        $('.b-participated .all a').click(function () {
            participatedYearSelector.val(0).trigger('change');
            return false;
        });
    }
});