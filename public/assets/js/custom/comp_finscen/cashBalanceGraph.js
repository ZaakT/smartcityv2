
var myFinancingCashBalanceChart = null;
function showFinancingCashBalanceChart(){
    if(myFinancingCashBalanceChart!=null){
        myFinancingCashBalanceChart.destroy();
    }
    var ctx = $('#FinancingCashBalanceChart').get(0).getContext('2d');
    myFinancingCashBalanceChart = new Chart(ctx, {
        type: 'bar',
        data: {
        labels: years,//[2010,2011,2012,2013,2014,2015,2016,2017],
        datasets: datasets
        },
        options: {
        title: {
            display: true,
            text: 'Cash Balance Profile',
            fontSize: 17,
        },

        scales: {
                        yAxes: [{
                            scaleLabel: {
                              display: true,
                              labelString: 'Cash Balance ( in '+deviseSym+' )'
                            },
                            ticks: {
                                callback: function(value, index, values) {
                                    if (parseInt(value) >= 1000||parseInt(value) <= -1000) {
                                        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                    } else {
                                        return value;
                                    }
                                }
                            }
                        }]
                    },
        tooltips: {
                        callbacks: {
                            // this callback is used to create the tooltip label
                            label: function(tooltipItem, data) {
                            // get the data label and data value to display
                            // convert the data value to local string so it uses a comma seperated number
                            var dataLabel = data.labels[tooltipItem.index];
                            // add the currency symbol $ to the label
                            var value = ': ' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].toLocaleString();
                            // make sure this isn't a multi-line label (e.g. [["label 1 - line 1, "line 2, ], [etc...]])
                            if (Chart.helpers.isArray(dataLabel)) {
                                // show value on first line of multiline label
                                // need to clone because we are changing the value
                                dataLabel = dataLabel.slice();
                                dataLabel[0] += value;
                            } else {
                                dataLabel += value;
                            }
                            // return the text to display on the tooltip
                            return dataLabel;
                            }
                        }
                    },
        legend: { 
            display: true 
            }
        }
    });
}

function getYears(){
    var list = [];
    $("thead .years").each(function(){
        var year = $(this).text();
        list.push(year);
    });
    return list;
}


function setCashbalance(){
    $('.cash_balance').each(function(){
        var id = $(this).attr('id');
        var temp = id.split('_');
        var idScen = temp[1];
        var year = temp[2];
        var scenName = temp[3];
        var text = $(this).text();
        text = text.replace(deviseSym,'');
        text = text.replace(',','');
        var val = parseFloat(text);
        if(cashbalance.hasOwnProperty(idScen)){
            cashbalance[idScen].push(val);
        } else {
            cashbalance[idScen] = [];
            cashbalance[idScen].push(val);
        }
        if(!list_scen.includes(idScen)){
            list_scen.push(idScen);
        }
        if(!scenNames.hasOwnProperty(idScen)){
            scenNames[idScen] = scenName;
        }
    });
}

function setDatasets(){
    for (const i in list_scen) {
        if (list_scen.hasOwnProperty(i)) {
            const idScen = list_scen[i];
            datasets.push( {
                label: scenNames[idScen],
                type: "line",
                borderColor: colors[1][i],
                data: cashbalance[idScen],
                fill: false,
                datalabels:{
                                display: false,
                            }
                }/* ,  {
                label: scenNames[idScen],
                type: "bar",
                backgroundColor: colors[0][i],
                data: cashbalance[idScen],
                datalabels:{
                                display: false,
                            }
                } */);
        }
    }
    

}

deviseName = "";
deviseSym = "";
cashbalance = {};
list_scen = [];
datasets = [];
scenNames = {};
function setNewDeviseCashFlows(name='GBP',sym='£'){
    deviseName = name;
    deviseSym = sym;
    years = getYears();
    setCashbalance();
    colors = getColorsArray(list_scen);
    setDatasets();
    showFinancingCashBalanceChart();
}
