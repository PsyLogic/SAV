$(document).ready(function () {

    var total_requests, opened, process, closed, models, diagnostic;
    var barChartModel = null;
    
    function colors(theme = 1) {
        var colors;
        switch(theme){
            case 1:
                    colors = [ "#F17354", "#F8B9A9", "#f08885", "#eea8a7", "#e7c7c7" ]
                    break;
            case 2:
                    colors = [ "#051937", "#004d7a", "#008793", "#00bf72", "#a8eb12" ]
                    break;
            case 3:
                    colors = ["#653fa7","#2196F3", "#FFBB00","#3cba9f","#e8c3b9"]
                    break;
        }

        return colors;
        
    }

    function initCharts() {

        $('#request').html(total_requests);
        $('#opened').html(opened);
        $('#process').html(process);
        $('#closed').html(closed);

        var diagnistic_label = Object.keys(diagnostic).sort(function(a,b){return diagnostic[a]-diagnostic[b]});
        var diagnostic_data = Object.values(diagnostic).sort();
        var diagnostic_percents = diagnostic_data.map(function ($value) {
            return (($value / closed) * 100).toFixed(1);
        });
        var pieChartSH = new Chart($('#pieChartSH'), {
            type: 'pie',
            data: {
                labels: diagnistic_label,
                datasets: [{
                    data: diagnostic_percents,
                    backgroundColor: colors(),
                    hoverBackgroundColor: colors(),
                }]
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data){
                            var label = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            return label + " %";
                        }
                    }
                }
            }
        });

        var barChartSH = new Chart($('#barChartSH'), {
            type: 'horizontalBar',
            data: {
                labels: diagnistic_label,
                datasets: [{
                    label: 'Diagnostic',
                    data: diagnostic_data,
                    backgroundColor: colors(),
                    hoverBackgroundColor: colors(),
                    borderWidth: 1,
                }]
            },
            options: {
                responsive:false,
                legend:{
                    display: false,
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true,
                        },
                        afterBuildTicks: function(axe){
                            axe.options.ticks.max = axe.end + 4 
                        }
                    }],
                    yAxes: [{
                        barPercentage: .8,
                        categoryPercentage: .6,
                    }]
                },
            }
        });
        
        var models_label = Object.keys(models).sort(function(a,b){ return models[a]-models[b]; });
        var models_data = Object.values(models).sort(function(a,b){return a-b});

        var models_percents = models_data.map(function (value) {
            return ((value / total_requests) * 100).toFixed(1);
        });
        var backgrounds = colors(3);
        var pieChartModel = new Chart($('#pieChartModel'), {
            type: 'pie',
            data: {
                labels: models_label,
                datasets: [{
                    data: models_percents,
                    backgroundColor: backgrounds,
                    hoverBackgroundColor: backgrounds,
                    borderColor: backgrounds,
                }]
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data){
                            var label = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            return label + " %";
                        }
                    }
                }
            }
        });

        var barChartModel = new Chart($('#barChartModel'), {
            type: 'bar',
            data: {
                labels: models_label,
                datasets: [{
                    label: 'Models',
                    data: models_data,
                    backgroundColor: backgrounds,
                    hoverBackgroundColor: backgrounds,
                    borderColor: backgrounds,
                    borderWidth: 1
                }]
            },
            options: {
                legend:{
                    display: false,
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
                    }],
                    xAxes: [{
                        barPercentage: .8,
                        categoryPercentage: .6
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            return "Total: "+label;
                        }
                    }
                }
            }
        });

        barChartModel = new Chart($('#barChartPModel'), {
            type: 'bar',
            data: {
                labels: ['Problem'],
                datasets: [{
                    label: 'Models',
                    data: [],
                }]
            },
            options: {
                legend:{
                    display: false,
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize:1,
                        },
                    }]
                }
            }
        });


        // Add Models to P model Select
        $.each(Object.keys(models),function(k,model){
            $('#pmodels').append('<option value="'+model+'">'+model+'</option>');
        });
    }

    function pieChartPModels(labels,data){
        var backgrounds = colors(3);

        if(barChartModel != null){
            barChartModel.destroy();
        }

        barChartModel = new Chart($('#barChartPModel'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Models',
                    data: data,
                    backgroundColor: '#007bff',
                    hoverBackgroundColor: '#007bfff2',
                    borderColor: '#007bff',
                    borderWidth: 1
                }]
            },
            options: {
                legend:{
                    display: false,
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize:1,
                        },
                    }],
                    xAxes: [{
                        barPercentage: .8,
                        categoryPercentage: .6,
                        ticks:{
                            autoSkip: false,
                            minRotation: 45
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            return "Total: "+label;
                        }
                    }
                }
            }
        });
    }
    
    // Init Dashboard
    $.ajax({
        type: 'GET',
        url: '/get-statistics',
        success: function (response) {
            total_requests = response.totalRequests || 0;
            opened = response.opened || 0;
            process = response.process || 0;
            closed = response.closed || 0;
            models = response.models || {};
            diagnostic = response.diagnostic || {};

            initCharts();
        },
        error: function (response) {
            console.log(response);
        }
    });
    
    // Onchange Model , Draw Problems Model Chart 
    $('#pmodels').change(function(){

        $.ajax({
            type: 'GET',
            url: '/pmodels/'+$(this).val(),
            success: function (response) {
                var labels=[];
                var data=[];
                $.each(response,function(k,rep){
                    labels.push(rep.content);
                    data.push(rep.countp);
                })
                pieChartPModels(labels,data);
            },
            error: function (response) {
                console.log(response);
            }
        });
        



    })


});