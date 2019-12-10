;!(function ($) {
    $.fn.classes = function (callback) {
        var classes = [];
        $.each(this, function (i, v) {
            var splitClassName = v.className.split(/\s+/);
            for (var j = 0; j < splitClassName.length; j++) {
                var className = splitClassName[j];
                if (-1 === classes.indexOf(className)) {
                    classes.push(className);
                }
            }
        });
        if ('function' === typeof callback) {
            for (var i in classes) {
                callback(classes[i]);
            }
        }
        return classes;
    };
})(jQuery);


function countChecked_bankUC(formName) {
    var n = 0;
    $("#"+formName+" input").each(function(){
        if(this.type.toLowerCase() =='checkbox'){
            if(this.checked==true){
                n++;
            }
        }
    });
    //console.log(n);
    $("#countUCSelectBankUC").text(n+" selected");

    if(n<=0){
        $("#help_BankUC").removeAttr('hidden');
    } else {
        $("#help_BankUC").attr('hidden', 'hidden');
    }    

    return n>0;
}

countChecked_bankUC("form_bankUC");





// ------------------------------------ CHARTS ------------------------------------

var myFinBankScoresChart = null;
function showFinBankChart(ucName,data){
    var chartData = [];
    var chartLabels = [];
    var backgroundColors = [];
    var borderColors = [];
    for(var key in data){
        var value = data[key];
        chartLabels.push(key);
        chartData.push(value);
        if(key!="Financial Bankability Score"){
            backgroundColors.push('rgba(255, 99, 132, 0.2)');
            borderColors.push('rgba(255, 99, 132, 1)');
        } else {
            backgroundColors.push('rgba(54, 162, 235, 0.2)');
            borderColors.push('rgba(54, 162, 235, 1)');
        }
    }

    $('#FinBankChart').removeAttr("hidden");
    if(myFinBankScoresChart!=null){
        myFinBankScoresChart.destroy();
    }

    var ctx = $('#FinBankChart').get(0).getContext('2d');
    myFinBankScoresChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartData,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            title : {
                display: true,
                text : ucName,
                fontSize : 20,
            },
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Score',
                        fontSize : 18,
                    },
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        max: 10,
                        //stepSize: 0.5,
                    }
                }]
            },
            legend: {
                display : false
            }
        }
    });
}

var mySocBankScoresChart = null;
function showSocBankChart(ucName,data){
    var chartData = [];
    var chartLabels = [];
    var backgroundColors = [];
    var borderColors = [];
    for(var key in data){
        var value = data[key];
        if(value != -1 || (key!="Risks" && key!="Non Cash Benefits Rating")){
            chartLabels.push(key);
            chartData.push(value);
            if(key!="Societal Bankability Score"){
                backgroundColors.push('rgba(255, 99, 132, 0.2)');
                borderColors.push('rgba(255, 99, 132, 1)');
            } else {
                backgroundColors.push('rgba(54, 162, 235, 0.2)');
                borderColors.push('rgba(54, 162, 235, 1)');
            }
        }
    }

    $('#SocBankChart').removeAttr("hidden");
    if(mySocBankScoresChart!=null){
        mySocBankScoresChart.destroy();
    }

    var ctx = $('#SocBankChart').get(0).getContext('2d');
    mySocBankScoresChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartData,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            title : {
                display: true,
                text : ucName,
                fontSize : 20,
            },
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Score',
                        fontSize : 18,
                    },
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        max: 10,
                        //stepSize: 0.5,
                    }
                }]
            },
            legend: {
                display : false
            }
        }
    });
}

var myBankDefineChart = null;
function showBankDefineChart(data){

    $('#BankDefineChart').removeAttr("hidden");
    if(myBankDefineChart!=null){
        myBankDefineChart.destroy();
    }

    var ctx = $('#BankDefineChart').get(0).getContext('2d');
    myBankDefineChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: ['Financial Bankability','Societal Bankabiltiy','Project Bankability'],
            datasets: [{
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            title : {
                display: false,
                text : "Title",
                fontSize : 20,
            },
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Score',
                        fontSize : 18,
                    },
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        max: 10,
                        stepSize: 1,
                    }
                }],
                yAxes: [{
                    ticks: {
                        fontSize : 15,
                    }
                }]
            },
            legend: {
                display : false
            }
        }
    });
}


var myBankOverallChart = null;
function showBankOverallChart(data){

    $('#BankOverallChart').removeAttr("hidden");
    if(myBankOverallChart!=null){
        myBankOverallChart.destroy();
    }

    var ctx = $('#BankOverallChart').get(0).getContext('2d');
    myBankOverallChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: ['Financial Bankability','Societal Bankabiltiy','Weighted Bankability'],
            datasets: [{
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            title : {
                display: false,
                text : "Title",
                fontSize : 20,
            },
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Score',
                        fontSize : 18,
                    },
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        max: 10,
                        stepSize: 1,
                    }
                }],
                yAxes: [{
                    ticks: {
                        fontSize : 15,
                    }
                }]
            },
            legend: {
                display : false
            }
        }
    });
}