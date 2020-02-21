function colorFilledGS(test){
    $("#table_GS input").each(function(){
        var element = $(this);
        if(test){
            element.css("background","#C3E6CB");
        } else {
            element.css("background","salmon");
        }
    });
}

function checkSum(){
    //console.log("--------------------");
    var sum = 0;
    $("#table_GS input").each(function(){
        //console.log(this);
        var element = $(this);
        var value = element.val();
        value = value!="" ? parseInt(value) : 0;
        if(value!=""){
            if(value>100){
                //element.val(parseInt(100));
                //pass
            } else {
                element.val(parseInt(value));
                sum += parseInt(value);
            }
        } else {
            element.val(parseInt(0));
        }
    });
    colorFilledGS(sum==100);
    return sum==100;
}

checkSum();



function showGlobalScoresChart(chartLabels,chartData){
    var ctx = $('#globalScoresChart').get(0).getContext('2d');
    var myGlobalScoresChart = new Chart(ctx, {
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
                text : "Global Scores per Use Case",
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
                      labelString: 'Global Scores',
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

//showGlobalScoresChart("globalScoresChart",["oui","non"],[2.5,7.5]);