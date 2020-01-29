
function showCompGraphNonQuant(compo,show){
    var compo2 = compo;
    if(compo == 'non cash benefits'){
        if(myCompChart_noncash!=null){
            myCompChart_noncash.destroy();
        }
        compo2 = "noncash";

    } else if(compo=="risks"){
        if(myCompChart_risks!=null){
            myCompChart_risks.destroy();
        }
    }

    if(show){
        $('#comp_graph_'+compo2).removeAttr("hidden");
    } else {
        $('#comp_graph_'+compo2).attr("hidden","hidden");
    }

    var title = toCapitalizeSentence(compo);
    var ctx = $('#comp_graph_'+compo2).get(0).getContext('2d');
    var data = getDataByCompNonQuant(projects_data,compo2);
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data[1],
            datasets: [{
                data: data[0],
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
                        stepValue : 1,
                        min : 0,
                        max : 10
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Score',
                        fontSize : 18
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

    if(compo == 'non cash benefits'){
        myCompChart_noncash = chart;
    } else if(compo=="risks"){
        myCompChart_risks = chart;
    }
}


function checkSelCompoNonQuant(){
    $("#sel_compo .compo").each(function(){
        var name = $(this).attr('name');
        var compo = name.split('_')[1];
        showCompGraphNonQuant(compo,this.checked);
    });
}

function getDataByCompNonQuant(projects_data,compo){
    var list = [];
    var list2 = [];
    for (const projID in projects_data) {
        if (projects_data.hasOwnProperty(projID)) {
            const list_data = projects_data[projID];
            if(list_data[compo] != -1){
                list.push(list_data[compo]);
                list2.push(projects_name[projID]);
            }
        }
    }
    return [list,list2];
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


function setNewDeviseNonQuant(sym){
    deviseSym = sym;
    projects_name = getProjectsName();
    projects_data = getProjectsData();
    colors = getColorsArray(projects_name);
    myCompChart_noncash = null;
    myCompChart_risks = null;
    checkSelCompoNonQuant();
}

//setNewDeviseNonQuant("£");

