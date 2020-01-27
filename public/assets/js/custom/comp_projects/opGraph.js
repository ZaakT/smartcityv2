
function showCompGraphOp(compo,show){
    var compo2 = compo;
    if(compo == 'opex'){
        if(myCompChart_opex!=null){
            myCompChart_opex.destroy();
        }

    } else if(compo=="revenues"){
        if(myCompChart_revenues!=null){
            myCompChart_revenues.destroy();
        }
    } else if(compo=="cash releasing benefits"){
        if(myCompChart_cashreleasing!=null){
            myCompChart_cashreleasing.destroy();
        }
        compo2 = "cashreleasing";
    } else if(compo=="wider cash benefits"){
        if(myCompChart_widercash!=null){
            myCompChart_widercash.destroy();
        }
        compo2 = "widercash";
    }

    if(show){
        $('#comp_graph_'+compo2).removeAttr("hidden");
    } else {
        $('#comp_graph_'+compo2).attr("hidden","hidden");
    }
    
    var title = toCapitalizeSentence(compo);
    var ctx = $('#comp_graph_'+compo2).get(0).getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: getDatasets(compo,projects_data[0])
        },
        options: {
            title : {
                display: true,
                text : title,
                fontSize : 20,
            },
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Compared Projects',
                        fontSize : 18,
                    },
                    ticks:{
                        display: true,
                        autoSkip: true,
                        maxTicksLimit: 20,
                    }
                }],
                yAxes: [{
                    ticks: {
                        display: true,
                        fontSize : 15,
                        min: 0,
                        callback: function(value) {
                            return value == 0 ? "" : value.toLocaleString("en-UK",{minimumFractionDigits:0,maximumFractionDigits:2});
                        }
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Value (in '+deviseSym+')',
                        fontSize : 18,
                    }
                }]
            },
            legend: {
                display : true
            },
            tooltips:{
                callbacks: {
                    label : function(item,data) {
                        return item.yLabel == 0 ? "" : item.yLabel.toLocaleString("en-UK",{minimumFractionDigits:0,maximumFractionDigits:2});
                    }
                }
            },
            plugins: {
                datalabels: {
                display: false,
                },
            }
        }
    });

    if(compo == 'opex'){
        myCompChart_opex = chart;
    } else if(compo=="revenues"){
        myCompChart_revenues = chart;
    } else if(compo=="cash releasing benefits"){
        myCompChart_cashreleasing = chart;
    } else if(compo=="wider cash benefits"){
        myCompChart_widercash = chart;
    }
}


function checkSelCompoOp(){
    $("#sel_compo .compo").each(function(){
        var name = $(this).attr('name');
        var compo = name.split('_')[1];
        showCompGraphOp(compo,this.checked);
    });
}

function getDataByComp(projects_data,compo){
    var list = [];
    for (const projID in projects_data) {
        if (projects_data.hasOwnProperty(projID)) {
            const list_data = projects_data[projID];
            list.push(list_data[compo]);
        }
    }
    return list;
}

function getProjectsData(){
    var list = {};
    var list2 = [];
    for (const projID in projects_name) {
        if (projects_name.hasOwnProperty(projID)) {
            const proj_name = projects_name[projID];
            list[projID] = {};
        }
    }
    $("#sel_compo .val").each(function(){
        var name = $(this).attr('name');
        var temp = name.split('_');
        var projID = temp[1];
        var compo = temp[2];
        var date = temp[3];
        var val = parseFloat($(this).val());
        if(list[projID][compo]){
            list[projID][compo][date] = val;
        } else {
            list[projID][compo] = [];
            list[projID][compo][date] = val;
        }

        if(!list2.includes(date)){
            list2.push(date);
        }
    });
    return [list,list2];
}

function getProjectsName(){
    var list = {};
    $("#sel_compo .proj").each(function(){
        var name = $(this).attr('name');
        var projID = name.split('_')[1];
        var val = $(this).val();
        list[projID] = val;
    });
    return list;
}

function getValues(list){
    var list2 = [];
    for (const key in list) {
        if (list.hasOwnProperty(key)) {
            const element = list[key];
            list2.push(element);
        }
    }
    return list2;
}

function getDatasets(compo,projects_data){
    var list = [];
    var i = 0;
    for (const projID in projects_data) {
        if (projects_data.hasOwnProperty(projID)) {
            const data = projects_data[projID][compo];
            var dataset = {
                label : projects_name[projID],
                borderColor : colors[1][i],
                backgroundColor : colors[0][i],
                data: getValues(data),
                fill : false
            };
            list.push(dataset);
            i++;
        }
    }
    return list;
}

function completeDate(data,dates){
    for (const projID in data) {
        if (data.hasOwnProperty(projID)) {
            const data_proj = data[projID];
            for (const compo in data_proj) {
                if (data_proj.hasOwnProperty(compo)) {
                    const data_compo = data_proj[compo];
                    for (const key in dates) {
                        if (dates.hasOwnProperty(key)) {
                            const date = dates[key];
                            if(!data_compo.hasOwnProperty(date)){
                                data_compo[date] = undefined;
                            }
                        }
                    }
                    data_compo.sort(compDates);
                }
            }
        }
    }
}

function compDates(a,b){
    var temp_a = a.split('/');
    var m_a = temp_a[0];
    var y_a = temp_a[1];
    var temp_b = b.split('/');
    var m_b = temp_b[0];
    var y_b = temp_b[1];
    if(y_a > y_b){
        return 1
    } else if(y_a < y_b) {
        return -1
    } else {
        if(m_a > m_b){
            return 1
        } else if(m_a < m_b) {
            return -1
        } else {
            return 0;
        }
    }
}

function setNewDeviseOperations(name,sym){
    deviseName = name;
    deviseSym = sym;
    projects_name = getProjectsName();
    projects_data = getProjectsData();
    colors = getColorsArray(projects_name);
    labels = projects_data[1];
    labels.sort(compDates);
    completeDate(projects_data[0],projects_data[1]);
    
    myCompChart_opex = null;
    myCompChart_revenues = null;
    myCompChart_cashreleasing = null;
    myCompChart_widercash = null;
    checkSelCompoOp();
}

//setNewDeviseOperations("£");