
function showCompGraphFinSoc(compo,show){
    var compo2 = compo;
    var title = toCapitalizeSentence(compo);
    var unit = deviseSym;
    if(compo == 'npv'){
        if(myCompChart_npv!=null){
            myCompChart_npv.destroy();
        }
        title = toCapitalizeSentence("NPV");

    } else if(compo=="societal npv"){
        if(myCompChart_socnpv!=null){
            myCompChart_socnpv.destroy();
        }
        compo2 = "socnpv";
        title = toCapitalizeSentence("societal NPV");

    } else if(compo=="return over investment"){
        if(myCompChart_roi!=null){
            myCompChart_roi.destroy();
        }
        compo2 = "roi";
        
    } else if(compo=="societal return over investment"){
        if(myCompChart_socroi!=null){
            myCompChart_socroi.destroy();
        }
        compo2 = "socroi";

    } else if(compo=="payback"){
        if(myCompChart_payback!=null){
            myCompChart_payback.destroy();
        }
        title = toCapitalizeSentence("payback / project duration");
        unit = "%";

    } else if(compo=="societal payback"){
        if(myCompChart_socpayback!=null){
            myCompChart_socpayback.destroy();
        }
        compo2 = "socpayback";
        title = toCapitalizeSentence("societal payback / project duration");
        unit = "%";
    }

    if(show){
        $('#comp_graph_'+compo2).removeAttr("hidden");
    } else {
        $('#comp_graph_'+compo2).attr("hidden","hidden");
    }
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
            },
        ]
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
                            return value == 0 ? "" : (100*value).toLocaleString("en-UK",{minimumFractionDigits:0,maximumFractionDigits:2});
                        },
                        min : unit == "%" ? 0 : undefined
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Value (in '+unit+')',
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
                      if(unit == "%"){
                        var ret = value == 0 ? "" : value.toLocaleString("en-UK",{style:"percent",minimumFractionDigits:0,maximumFractionDigits:2});
                      } else {
                        var ret = value == 0 ? "" : value.toLocaleString("en-UK",{minimumFractionDigits:0,maximumFractionDigits:2});
                      }
                      return ret;
                  }
                }
            },
            tooltips:{
                callbacks: {
                    label : function(item,data) {
                        return item.yLabel == 0 ? "" : (100*item.yLabel).toLocaleString("en-UK",{minimumFractionDigits:0,maximumFractionDigits:2});
                    }
                }
            }
        }
    });

    if(compo == 'netcash'){
        myCompChart_npv = chart;
    } else if(compo=="netsoccash"){
        myCompChart_socnpv = chart;
    } else if(compo=="netsoccash"){
        myCompChart_roi = chart;
    } else if(compo=="netsoccash"){
        myCompChart_socroi = chart;
    } else if(compo=="netsoccash"){
        myCompChart_payback = chart;
    } else if(compo=="netsoccash"){
        myCompChart_socpayback = chart;
    }
}


function checkSelCompoFinSoc(){
    $("#sel_compo .compo").each(function(){
        var name = $(this).attr('name');
        var compo = name.split('_')[1];
        showCompGraphFinSoc(compo,this.checked);
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


function setNewDeviseFinSoc(name,sym){
    deviseName = name;
    deviseSym = sym;
    projects_name = getProjectsName();
    projects_data = getProjectsData();
    colors = getColorsArray(projects_name);
    myCompChart_npv = null;
    myCompChart_socnpv = null;
    myCompChart_roi = null;
    myCompChart_socroi = null;
    myCompChart_payback = null;
    myCompChart_socpayback = null;
    checkSelCompoFinSoc();
}

//setNewDeviseFinSoc("£");

