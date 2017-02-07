$(function() {
    var values = $('#morris-area-chart').data('values');

    var dataLine = Array();
    values.forEach(function(i){
        dataLine.push({
            date: i.cdate,
            money: i.cash
        });
    });
    console.log(dataLine);
    Morris.Line({
        element: 'morris-area-chart',
        data: dataLine,
        xkey: 'date',
        ykeys: ['money'],
        labels: ['money'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Download Sales",
            value: 12
        }, {
            label: "In-Store Sales",
            value: 30
        }, {
            label: "Mail-Order Sales",
            value: 20
        }],
        resize: true
    });


    values = $('#morris-bar-chart').data('values');

    var dataBar = Array();
    values.forEach(function(i){
        dataBar.push({
            y: i.cdate,
            a: i.cash
        });
    });
    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 90
        }, {
            y: '2007',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2010',
            a: 50,
            b: 40
        }, {
            y: '2011',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });
    
});
