var partnerStatistics = null;

$(function () {

});
CParnerStatistics = function () {
    this.Roles = null;
    this.Dates = null;
    this.RegistrationsAll = null;
    this.RegistrationsDelta = null;
    this.Payments = null;
    this.Count = null;

    this.chartRegistrationsAll = null;
    this.chartRegistrationsDelta = null;

    this.legendAll = {
        position:'top',
        maxLines:3
    };
};

CParnerStatistics.prototype = {
    init:function () {
        var self = this;
        var datesRangeText = $("#datesRange").find("span");

        $("#datesSlider").slider({
            range:true,
            values:[0, self.Dates.length - 1],
            min:0,
            max:self.Dates.length - 1,
            step:1,
            slide:function (event, ui) {
                datesRangeText.text(self.Dates[ui.values[0]] + " - " + self.Dates[ui.values[1]]);
            },
            stop:function (event, ui) {
                self.drawRegistrationAll(ui.values[0], ui.values[1] + 1);
                self.drawRegistrationDelta(ui.values[0], ui.values[1] + 1);
            }
        });
        datesRangeText.text(self.Dates[0] + "-" + self.Dates[self.Dates.length - 1]);

        self.drawRegistrationAll(0, this.Dates.length);
        self.drawRegistrationDelta(0, this.Dates.length);
        self.drawPayments();
        self.drawCount();
    },
    drawRegistrationAll:function (from, to) {
        var roles = this.Roles.slice(0);
        roles.splice(0, 0, 'Даты');

        var data = this.RegistrationsAll.slice(from, to);
        data.splice(0, 0, roles);
        data = google.visualization.arrayToDataTable(data);

        var options = {
            height:400,
            lineWidth:2,
            chartArea:{left:50, top:50, width:'100%', height:'80%'},
            title:null,
            legend:this.legendAll,
            isStacked:true,
            fontSize:13
        };

        if (this.chartRegistrationsAll == null) {
            this.chartRegistrationsAll = new google.visualization.AreaChart(document.getElementById('chart-registrations-all'));
        }
        this.chartRegistrationsAll.draw(data, options);
    },
    drawRegistrationDelta:function (from, to) {
        var roles = this.Roles.slice(0);
        roles.splice(0, 0, 'Даты');

        var data = this.RegistrationsDelta.slice(from, to);
        data.splice(0, 0, roles);
        data = google.visualization.arrayToDataTable(data);

        var options = {
            height:400,
            lineWidth:2,
            chartArea:{left:50, top:50, width:'100%', height:'80%'},
            title:null,
            legend:this.legendAll,
            isStacked:true,
            displayAnnotations:true,
            fontSize:13
        };

        if (this.chartRegistrationsDelta == null) {
            this.chartRegistrationsDelta = new google.visualization.AreaChart(document.getElementById('chart-registrations-delta'));
        }
        this.chartRegistrationsDelta.draw(data, options);
    },
    drawPayments:function () {
        var roles = this.Roles.slice(0);
        roles.splice(0, 0, 'Роли');
        //roles.push({role: 'style'});

        var data = this.Payments.slice(0);
        data.splice(0, 0, roles);
        data = google.visualization.arrayToDataTable(data);

        var options = {
            height:400,
            legend:this.legendAll,
            chartArea:{left:50, top:50, width:'100%', height:'80%'},
            bar:{groupWidth:'75%'},
            isStacked:true,
            fontSize:13
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('chart-payments'));
        chart.draw(data, options);
    },
    drawCount:function () {
        var data = this.Count.slice(0);
        data.splice(0, 0, ['Статус', 'Количество']);
        data = google.visualization.arrayToDataTable(data);

        var options = {
            height:400,
            legend:this.legendAll,
            chartArea:{left:50, top:50, width:'100%', height:'80%'},
            bar:{groupWidth:'75%'},
            pieSliceText:'value',
            fontSize:13
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart-count'));
        chart.draw(data, options);
    }
};