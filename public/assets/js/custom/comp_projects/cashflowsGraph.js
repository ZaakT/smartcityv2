
function showCompGraphCashFlows(compo,show){
    var compo2 = compo;
    if(compo == 'net cash'){
        if(myCompChart_netcash!=null){
            myCompChart_netcash.destroy();
        }
        compo2 = "netcash";

    } else if(compo=="net societal cash"){
        if(myCompChart_netsoccash!=null){
            myCompChart_netsoccash.destroy();
        }
        compo2 = "netsoccash";
    }

    if(show){
        $('#comp_graph_'+compo2).removeAttr("hidden");
    } else {
        $('#comp_graph_'+compo2).attr("hidden","hidden");
    }
    var title = toCapitalizeSentence(compo);
    var ctx = $('#comp_graph_'+compo2).get(0).getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.values(projects_name),
            datasets: [{
                data: getDataByComp(projects_data,compo2),
                backgroundColor: colors[0],
                borderColor : colors[1],
                borderWidth: 1
            }]
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
                    }
                }],
                yAxes: [{
                    ticks: {
                        fontSize : 15,
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
                display : false
            },
            plugins: {
                datalabels: {
                  anchor: 'center',
                  align: 'center',
                  font: {
                    size: 15,
                  },
                  formatter: function(value){
                      var ret = value == 0 ? "" : value.toLocaleString("en-UK",{minimumFractionDigits:0,maximumFractionDigits:2});
                      return ret;
                  }
                }
            },
            tooltips:{
                callbacks: {
                    label : function(item,data) {
                        return item.yLabel == 0 ? "" : item.yLabel.toLocaleString("en-UK",{minimumFractionDigits:0,maximumFractionDigits:2});
                    }
                }
            }
        }
    });

    if(compo == 'netcash'){
        myCompChart_netcash = chart;
    } else if(compo=="netsoccash"){
        myCompChart_netsoccash = chart;
    }
}


function checkSelCompoCashFlows(){
    $("#sel_compo .compo").each(function(){
        var name = $(this).attr('name');
        var compo = name.split('_')[1];
        showCompGraphCashFlows(compo,this.checked);
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
        var val = parseFloat($(this).val());
        list[projID][compo] = val;
    });
    return list;
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


function setNewDeviseCashFlows(name,sym){
    deviseName = name;
    deviseSym = sym;
    projects_name = getProjectsName();
    projects_data = getProjectsData();
    colors = getColorsArray(projects_name);
    myCompChart_netcash = null;
    myCompChart_netsoccash = null;
    checkSelCompoCashFlows();
}

//setNewDeviseCashFlows("£");

