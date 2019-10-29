var myRanksChart = null;
function showRanksChart(id,chartTitle,chartLabels,chartData,n){
    $('#'+id).removeAttr("hidden");
    if(myRanksChart!=null){
        myRanksChart.destroy();
    }
    var ctx = $('#'+id).get(0).getContext('2d');
    myRanksChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            title : {
                display: true,
                text : chartTitle,
                fontSize : 20,
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        min : 0,
                        max : n,
                        stepSize: 1,
                    },
                    scaleLabel: {
                      display: true,
                      labelString: 'Ranks',
                      fontSize : 18,
                    },
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Criteria',
                        fontSize : 18,
                    },
                }]
            },
            legend: {
                display : false
            }
        }
    });
}

var myScoresChart = null;
function showScoresChart(id,chartTitle,chartLabels,chartData){
    $('#'+id).removeAttr("hidden");
    if(myScoresChart!=null){
        myScoresChart.destroy();
    }
    var ctx = $('#'+id).get(0).getContext('2d');
    myScoresChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            title : {
                display: true,
                text : chartTitle,
                fontSize : 20,
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        max: 10,
                        //stepSize: 0.5,
                    },
                    scaleLabel: {
                      display: true,
                      labelString: 'Scores',
                      fontSize : 18,
                    },
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Use Cases',
                        fontSize : 18,
                    },
                }]
            },
            legend: {
                display : false
            }
        }
    });
}

