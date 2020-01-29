deviseName = "";
deviseSym = "";
cashbalance = [];
function setNewDeviseFin(name='GBP',sym='£'){
    values = {};
    values2 = {};
    deviseName = name;
    deviseSym = sym;
    
    $("#financing_table_2 .sourceCat").each(function(){
        var id = $(this).attr('id').split('_');
        var id_cat = parseInt(id[1]);
        values[id_cat] = {'val':0,'share':0};
        
    });
    
    $("#financing_table_2 .sourceValues").each(function(){
        var id = $(this).attr('id').split('_');
        var id_cat = parseInt(id[1]);
        var id_source = parseInt(id[2]);
        var val = $(this).text();
        val = parseFloat(val) ;
        values[id_cat][id[0]] += val;
    });
    
    for (const id_cat in values) {
        if (values.hasOwnProperty(id_cat)) {
            const tab = values[id_cat];
            $("#val_"+id_cat).text(tab['val'].toLocaleString('en-EN', {style:"currency", currency:deviseName,minimumFractionDigits: 0, maximumFractionDigits: 2}));
            $("#share_"+id_cat).text(tab['share'].toLocaleString('en-EN', {minimumFractionDigits: 0, maximumFractionDigits: 2})+" %");
        }
    }
/* 
    var i = 0;
    $("#financing_table_5 .sourceCat").each(function(){
        var id = $(this).attr('id').split('_');
        var id_cat = parseInt(id[1]);
        values[id_cat] = { i : {'val':0}};
        
    }); */
    
    $("#financing_table_5 .sourceValues").each(function(){
        var id = $(this).attr('id').split('_');
        var id_cat = parseInt(id[1]);
        var id_source = parseInt(id[2]);
        var i = parseInt(id[3]);

        var val = $(this).text();
        val = val ? parseFloat(val) : 0;
        if(values2[id_cat]){
            if(values2[id_cat][i]){
                var val_old = values2[id_cat][i];
                values2[id_cat][i] = val+val_old;
            } else {
                values2[id_cat][i] = val;
            }
        } else {
            values2[id_cat] = [];
            values2[id_cat][i] = val;
        }

    });
    var tot = [];
    for (const id_cat in values2) {
        if (values2.hasOwnProperty(id_cat)) {
            const tab = values2[id_cat];
            for (const i in tab) {
                if (tab.hasOwnProperty(i)) {
                    var val = tab[i] ? tab[i] : 0;
                    $("#financing_table_5 #val_"+id_cat+"_"+i).text(val.toLocaleString('en-EN', {style:"currency", currency:deviseName,minimumFractionDigits: 0, maximumFractionDigits: 2}));
                    if(tot[i]){
                        tot[i] += tab[i];
                    } else {
                        tot[i] = tab[i];
                    }
                }
            }
        }
    }
    var netcash = [];
    cashbalance = [];
    for (const i in tot) {
        if (tot.hasOwnProperty(i)) {
            const val = tot[i] ? tot[i] : 0;
            $("#financing_table_5 #tot_II_"+i).text(val.toLocaleString('en-EN', {style:"currency", currency:deviseName,minimumFractionDigits: 0, maximumFractionDigits: 2}));

            var tot_I = $("#financing_table_5 #tot_I_"+i).text().split(deviseSym)[1];
            tot_I = tot_I.replace(/,/g,'');
            tot_I = parseFloat(tot_I);
            var tot_II = val;
            netcash[i] = tot_II - tot_I;
            cashbalance[i] = i > 0 ? cashbalance[i-1] + netcash[i] : netcash[i];
            $("#financing_table_5 #netcash_"+i).text(netcash[i].toLocaleString('en-EN', {style:"currency", currency:deviseName,minimumFractionDigits: 0, maximumFractionDigits: 2}));
            $("#financing_table_5 #cashbalance_"+i).text(cashbalance[i].toLocaleString('en-EN', {style:"currency", currency:deviseName,minimumFractionDigits: 0, maximumFractionDigits: 2}));
        }
    }
}

var myFinancingOptChart = null;
function showFinancingOptChart(labels){
    if(myFinancingOptChart!=null){
        myFinancingOptChart.destroy();
    }
    var data = [];
    for (const id_cat in values) {
        if (values.hasOwnProperty(id_cat)) {
            const tab = values[id_cat];
            var val = tab['share'];
            if(val!=0){
                data.push(val);
            }
        }
    }

    var ctx = $('#FinancingOptChart').get(0).getContext('2d');
    myFinancingOptChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                label: "Funding Sources Categories",
                backgroundColor: ['#2f7ed8', '#0d233a', '#8bbc21', '#910000', '#1aadce',
                '#492970'],
                data: data
              }]
        },
        options: {
            responsive: true,
            title: {
              display: true,
              text: 'Financing share in % for categories'
            },
            legend: {
              display: false
            }
        }
    });
}


var myFinancingBenefChart = null;
function showFinancingBenefChart(labels,data){
    if(myFinancingBenefChart!=null){
        myFinancingBenefChart.destroy();
    }

    var ctx = $('#FinancingBenefChart').get(0).getContext('2d');
    myFinancingBenefChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                label: "Beneficiaries",
                backgroundColor: ['#2f7ed8', '#0d233a', '#8bbc21', '#910000', '#1aadce',
                '#492970'],
                data: data
              }]
        },
        options: {
            responsive: true,
            title: {
              display: true,
              text: 'Share of Funding in %'
            },
            legend: {
              display: false
            }
        }
    });
}



var myFinancingCashBalanceChart = null;
function showFinancingCashBalanceChart(data){
    if(myFinancingCashBalanceChart!=null){
        myFinancingCashBalanceChart.destroy();
    }
    var ctx = $('#FinancingCashBalanceChart').get(0).getContext('2d');
    myFinancingCashBalanceChart = new Chart(ctx, {
        type: 'bar',
        data: {
        labels: getYears(),//[2010,2011,2012,2013,2014,2015,2016,2017],
        datasets: [{
            label: "Cash Balance",
            type: "line",
            borderColor: "#8e5ea2",
            data: cashbalance,
            fill: false,
            datalabels:{
                            display: false,
                        }
            }/* ,  {
            label: "Cash Balance",
            type: "bar",
            backgroundColor: "rgba(135, 165, 255,0.5)",
            data: cashbalance,
            datalabels:{
                            display: false,
                        }
            } */,
        ]
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
            display: false 
            }
        }
    });
}

function getYears(){
    var list = [];
    $("#financing_table_5 thead .years").each(function(){
        var year = $(this).text();
        list.push(year);
    });
    return list;
}







function fin2csv(idTable,projName,scenName,sourceName,sourceID,selDevSym="£"){
    var text = "";
    var labels = [];
    var data = [];
    var i = 0;
    var j = 0;
    var name = "output_"+projName+"_projectDashboard";
    labels.push("Project","Selected Scenario");

    if(idTable == "financing_table"){
        sourceName = sourceName.replace(" ","");
        name += "_financing_"+sourceName;
        i = 0;
        $("#"+idTable+"_"+sourceID+" thead tr").each(function(){
            $(this).children('th').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                labels.push(text);
            });
        });
        i = 0;
        $("#"+idTable+"_"+sourceID+" tbody tr").each(function(){
            if(i == 0){
                data.push([projName,scenName]);
            } else {
                data.push(["",""]);
            }
            $(this).children('td').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                text = text.replace(/\n/g,'');
                data[i].push(text);
            });
            i++;
        });

    } else if(idTable == "financing_table_2"){
        sourceName = sourceName.replace(" ","");
        name += "_financing_recap";
        i = 0;
        $("#"+idTable+" thead tr").each(function(){
            $(this).children('th').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                text = text.replace(selDevSym,'');
                labels.push(text);
            });
        });
        i = 0;
        $("#"+idTable+" tbody tr").each(function(){
            if(i == 0){
                data.push([projName,scenName]);
            } else {
                data.push(["",""]);
            }
            $(this).children('td').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                text = text.replace(selDevSym,'');
                text = text.replace(/\n/g,'');
                data[i].push(text);
            });
            i++;
        });
    } else if(idTable == "financing_table_3"){
        sourceName = sourceName.replace(" ","");
        name += "_financing_benef";
        i = 0;
        $("#"+idTable+" thead tr").each(function(){
            $(this).children('th').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                text = text.replace(selDevSym,'');
                labels.push(text);
            });
        });
        i = 0;
        $("#"+idTable+" tbody tr").each(function(){
            if(i == 0){
                data.push([projName,scenName]);
            } else {
                data.push(["",""]);
            }
            $(this).children('td').each(function(){
                text = $(this).text();
                text = text.replace("in "+selDevSym,'');
                text = text.replace(selDevSym+" ",'');
                text = text.replace(selDevSym,'');
                text = text.replace(/\n/g,'');
                data[i].push(text);
            });
            i++;
        });
    } else if(idTable == "financing_table_5"){
        sourceName = sourceName.replace(" ","");
        name += "_financing_cashflows";
        i = 0;
        $("#"+idTable+" thead tr").each(function(){
            $(this).children('th').each(function(){
                text = $(this).text();
                labels.push(text);
            });
        });
        i = 0;
        $("#"+idTable+" tbody tr").each(function(){
            if(i == 0){
                data.push([projName,scenName]);
            } else {
                data.push(["",""]);
            }
            $(this).children('td').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                text = text.replace(selDevSym,'');
                text = text.replace(/^\s{1}/,'');
                data[i].push(text);
            });
            i++;
        });
    }
    //console.log(labels);
    //console.log(data);
    download_csv(name,labels,data);
}

