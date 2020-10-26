<script src="js/plugin/sparkline/jquery.sparkline.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>

<script type="text/javascript">

    $(document).ready(function () {

        pageSetUp();

        f_chart_color();

        Highcharts.chart('gfc_chart_1', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Peratus (%) Pematuhan Nilai Batas PPKAS (Udara Bersih) 2014 Melalui Pemantauan CEMS Mengikut Negeri'
            },
            subtitle: {
                text: '27 Oktober 2020'
            },
            xAxis: {
                categories: ['Johor', 'Kedah', 'N.Sembilan', 'Pahang', 'Perak', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu'],
                gridLineWidth: 1
            },
            yAxis: {
                title: {
                    text: 'Bilangan Industri Tidak Patuh'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 50,
                floating: true,
                borderWidth: 1,
                backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                shadow: true
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: false
                    }
                },
                series: {
                    groupPadding: 0.1
                }
            },
            series: [
                {
                    name: 'Fuel Burning Equipment',
                    data: [5, 3, 2, 8, 3, 9, 3, 2, 5]
                },
                {
                    name: 'Heat and Power Generation',
                    data: [2, 1, 0, 2, 4, 1, 1, 3, 1]
                },
                {
                    name: 'Ferrous Metals',
                    data: [1, 1, 1, 1, 1, 1, 4, 1, 2]
                },
                {
                    name: 'Non-Ferrous Metals',
                    data: [2, 0, 1, 1, 1, 1, 2, 1, 2]
                },
                {
                    name: 'Oil and Gas Industries',
                    data: [0, 1, 1, 0, 2, 0, 1, 0, 0]
                },
                {
                    name: 'Non-Metallic Industry',
                    data: [0, 0, 1, 0, 1, 0, 0, 0, 0]
                },
                {
                    name: 'Waste Incinerator',
                    data: [0, 0, 0, 0, 0, 0, 1, 0, 0]
                }
            ],
            credits: {
                enabled: false
            }
        });

        Highcharts.chart('gfc_chart_2', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Peratus (%) Pematuhan Nilai Batas PPKAS (Udara Bersih) 2014 Melalui Pemantauan CEMS Mengikut Jenis Industri'
            },
            subtitle: {
                text: '27 Oktober 2020'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -5,
                y: 50,
                floating: true,
                borderWidth: 1,
                shadow: true
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.y} ({point.percentage:.1f}%)'
                    },
                    showInLegend: true
                }
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y} ({point.percentage:.1f}%)</b>'
            },
            series: [
                {
                    name: 'Jumlah',
                    data: [
                        {name:'Fuel Burning Equipment', y:40, sliced:true, selected:true},
                        {name:'Heat and Power Generation', y:15},
                        {name:'Ferrous Metals', y:13},
                        {name:'Non-Ferrous Metals', y:11},
                        {name:'Oil and Gas Industries', y:5},
                        {name:'Non-Metallic Industry', y:3},
                        {name:'Waste Incinerator', y:1}
                    ]
                }
            ],
            credits: {
                enabled: false
            }
        });
    });

</script>