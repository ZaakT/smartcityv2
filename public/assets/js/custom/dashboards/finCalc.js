
function setNewDeviseFin(name){
    deviseName = name;
    values = {};
    
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


function fin2csv(idTable,projName,scenName,sourceName,sourceID,selDevSym="£"){
    var text = "";
    var labels = [];
    var data = [];
    var i = 0;
    var j = 0;
    console.log(sourceName)
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

    }
    //console.log(labels);
    //console.log(data);
    download_csv(name,labels,data);
}

