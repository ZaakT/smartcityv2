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
    //console.log(data);
    //$('#BankDefineChart').removeAttr("hidden");
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

    //$('#BankOverallChart').removeAttr("hidden");
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

function calcDefineScores(weighted_scores){
    //var weighted_scores = {1:{'fin':1,'soc':2},2:{'fin':1,'soc':2},3:{'fin':1,'soc':2}};
    var fin_score = 0.;
    var soc_score = 0.;
    $('#bank_uc_table :checkbox').each(function(){
        var ucID = this.id;
        if(this.checked){
            fin_score += weighted_scores[ucID]['fin'];
            soc_score += weighted_scores[ucID]['soc'];
        }
    });
    var proj_score = (fin_score+soc_score)/2;
    
    var fin_score = fin_score.toLocaleString("en-EN", {minimumFractionDigits: 0, maximumFractionDigits: 1})
    var soc_score = soc_score.toLocaleString("en-EN", {minimumFractionDigits: 0, maximumFractionDigits: 1})
    var proj_score = proj_score.toLocaleString("en-EN", {minimumFractionDigits: 0, maximumFractionDigits: 1})


    fillScores(fin_score,soc_score,proj_score);
    showBankDefineChart([parseFloat(fin_score),parseFloat(soc_score),parseFloat(proj_score)]);
    calcOverallScores();
}

function fillScores(fin_score,soc_score,proj_score){
    $("#bank_define_table #finbank").text(fin_score);
    $("#bank_define_table #socbank").text(soc_score);
    $("#bank_define_table #projbank").text(proj_score);
    $("#bank_overall_table #projbank").text(proj_score);
}

function colorFilled(test){
    $("#bank_overall_table input").each(function(){
        var element = $(this);
        if(test){
            element.css("background","palegreen");
        } else {
            element.css("background","salmon");
        }
    });
}

function checkSum(){
    //console.log("--------------------");
    var sum = 0;
    $("#bank_overall_table input").each(function(){
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
    colorFilled(sum==100);
    //console.log(sum==100);
    return sum==100;
}

function checkInputOverall(){
    if(checkSum()){;
        calcOverallScores();
    } else {
        showBankOverallChart([0,0,0]);
    }
}

function calcOverallScores(){
    var fin_score = parseFloat($("#bank_define_table #finbank").text());
    var soc_score = parseFloat($("#bank_define_table #socbank").text());
    var weight_fin = $("#bank_overall_table #finbank_weight").val()/100;
    var weight_soc = $("#bank_overall_table #socbank_weight").val()/100;
    var weighted_score = weight_fin*fin_score + weight_soc*soc_score;
    //console.log([fin_score,soc_score,weighted_score]);
    showBankOverallChart([fin_score,soc_score,weighted_score]);
}

try{
    showBankDefineChart([0,0,0]);
    checkInputOverall();
} catch {
    //do nothing
} finally {
    //do nothing
}