
var tr_id = [];

$("#cball_table tr").each(function() {
    tr_id.push(this.id);
});




function getUcSelected(){
    //return -1 if we have to seletec all use cases else return the UC seleted.

    var selectEelemnt = document.getElementById("uc");
    try{

        var ucSeleted = selectEelemnt.options[selectEelemnt.selectedIndex].value;
        return ucSeleted;
    } catch(e){
        return 0;
    }
    
}




;
function updateDataPD(){
    var data = $('#data').data("toShow");
    var uc = getUcSelected();
    var ucData = [];
    var deviseName = $('#deviseName').text();

    console.log(uc, data);
    for(let i =0; i< data.length; i++){       
        if(data[i][0]==uc){
            ucData = data[i].slice(1, data[i].length);
        }
    }
    
    for(let i = 0; i < ucData[0].length; i++){
        for(let j = 0; j < ucData.length; j++){
            $("#"+i+"_"+j).text(Math.round(ucData[j][i]).toLocaleString("en-UK",
            {
                style:"currency", 
                currency:deviseName,
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            }));
            
        }
    }
    drawCharts();
}

updateDataPD();



function getLevel(id){

    return $("#"+id+"_level").text().split("\n")[0];
}
function findShowHide(id, showType=true){
    var level = getLevel(id).split('.');
    //console.log(tr_id);
    tr_id.forEach(tr => {
        
        var levelTr = getLevel(tr).split('.');
        //console.log(tr);
        //console.log(levelTr, level);
        if(tr!=id){
            if(level[0]==levelTr[0] && (level[1]==0 || (level[1]==levelTr[1] && level[2]==0) )){
                if(showType){
                    show(tr);
                }else{
                    hide(tr);
                }
            }
        }
    });
}



function turnArrow(id){
    try{ 
        if( $("#"+id+"_left")[0].hasAttribute("hidden") ){
            $('#'+id+'_bottom').attr('hidden', true);
            $('#'+id+'_left').removeAttr('hidden');
        }else if( $("#"+id+"_bottom")[0].hasAttribute("hidden") ){
            $('#'+id+'_left').attr('hidden', true);
            $('#'+id+'_bottom').removeAttr('hidden');

        }

    }catch(error){}
}
function show(id){
    //console.log("I show :"+id);
    turnArrow(id);       
    $('#'+id).removeAttr('hidden');



}

function hide(id){
    //console.log("I hide :"+id);    if(test)
    turnArrow(id);
    $('#'+id).attr('hidden', true);
        

}

function show_hide_tab(id){
    if ( $("#"+id+"_left")[0].hasAttribute("hidden") ){
        turnArrow(id);
        findShowHide(id, false);
    } else {
        turnArrow(id);
        findShowHide(id, true);
    }

}

function isMonth(id){
    return ($("#"+id).text()).split('/').length >1 ;
}

function hideShowMonths(hide, iMax, jMax){
    var data = $('#data').data("toShow");
    var uc = getUcSelected();
    var ucData = [];

    //console.log(uc, data);
    for(let i =0; i< data.length; i++){       
        if(data[i][0]==uc){
            ucData = data[i].slice(1, data[i].length);
        }
    }
    
    for(let j = 0; j < jMax; j++){
        if(isMonth(j)){
            // On s'occupe des titres
            if(hide){ 
                $("#"+j).attr('hidden', true);
            }
            else{  
                $("#"+j).removeAttr('hidden');
            }
            for(let i = 0; i < iMax; i++){
                // On s'occupe des données
                if(hide){
                    $("#"+i+"_"+j).attr('hidden', true);
                }
                else{
                    $("#"+i+"_"+j).removeAttr('hidden');
                }
            }
        }
    }
}

function changeMonths(){
    var data = $('#data').data("toShow");
    var uc = getUcSelected();
    var ucData = [];

    for(let i =0; i< data.length; i++){       
        if(data[i][0]==uc){
            ucData = data[i].slice(1, data[i].length);
        }
    }
    iMax = ucData[0].length;
    jMax = ucData.length;
    j = 0;
    while(!isMonth(j)){
        j++;
    }
    if($("#"+j)[0].hasAttribute("hidden")){
        hideShowMonths(false, iMax, jMax);
    }else{
        hideShowMonths(true, iMax, jMax);
    }

}

function createTable(iMax, jMax, idFather, idTable){

    table = document.createElement('table');
    father = document.getElementById(idFather);
    table.id = idTable;
    father.appendChild(table);

  
    tbody = document.createElement('tbody');  
    table.appendChild(tbody);

    for(let i = 0; i < iMax; i++){
        var newRow   = table.insertRow();
        for(let j = 0; j < jMax; j++){
            var newCell  = newRow.insertCell();
            newCell.id = idTable+"_"+i+"_"+j;
        }
    }

    return table;
}

function addRow(table, jMax){
    var i = $("#"+table.id+" tr").length;
    var newRow   = table.insertRow();
    for(let j = 0; j < jMax; j++){
        var newCell  = newRow.insertCell();
        newCell.id = table.id+"_"+i+"_"+j;
    }
}





function drawCharts(){
    var data = $('#data').data("toShow");
    var years = $('#data').data("years");
    var months = $('#data').data("months");
    var uc = getUcSelected();
    var ucData = [];
    console.log(data);

    for(let i =0; i< data.length; i++){       
        if(data[i][0]==uc){
            ucData = data[i].slice(1, data[i].length);
        }
    }

    iMax = ucData[0].length;
    jMax = ucData.length;
    table = createTable(0, 2, "graph", "graphCell");
    removeGraphs();
    yearLevelData = [];
    monthLevelData = []
    for(let i = 0; i < iMax; i++){
        var yearsData = [];
        var monthsData = [];
        var lineName = $("#"+"lineName_"+i).text();
        var levelTr = getLevel(tr_id[i+1]).split('.');
        console.log(levelTr);
        for(let j = 0; j < jMax; j++){
            //console.log(document.getElementById(j).textContent);
            if(isMonth(j)){
                monthsData.push(ucData[j][i]);
            }else if($("#"+j).text()!="Total"){
                yearsData.push(ucData[j][i]);
            }

        }
        addRow(table, 2);
        var div = createDiv("graphCell_"+i+"_0", "container_"+i*2);
        var canvas = createCanvas(div.id, "canevas_"+i*2);
        createGraph(lineName + " Years ", canvas, yearsData, years);
        var div = createDiv("graphCell_"+i+"_1", "container_"+i*2+1);
        var canvas = createCanvas(div.id, "canevas_"+i*2+1);
        createGraph(lineName + " Months ", canvas, monthsData, months);
        /*if(yearLevelData.length>0){
            if(levelTr[1] == 0 && levelTr[0]>1){
                addRow(table, 2);
                var div = createDiv("graphCell_"+i+"_0", "container_summary_1_"+i*2);
                var canvas = createCanvas(div.id, "canevas_summary_1_"+i*2);
                graphYear = createGraph(lineName + "", canvas, years);
                yearLevelData.forEach(element => {
                    if(element[2][2]== 0 && element[2][0]==levelTr[0]-1){
                        addDataset(graphYear, element[0], element[1]);
                    }
                });

                var div = createDiv("graphCell_"+i+"_1", "container_summary_1_"+i*2+1);
                var canvas = createCanvas(div.id, "canevas_summary_1_"+i*2+1);
                graphMonth = createGraph(lineName + "", canvas,[], months);
                monthLevelData.forEach(element => {
                    if(element[2][2]== 0 && element[2][0]==levelTr[0]-1){
                        addDataset(graphMonth, element[0], element[1]);
                    }
                });
            }else if(levelTr[2] == 0){
                addRow(table, 2);
                var div = createDiv("graphCell_"+i+"_0", "container_summary_2_"+i*2);
                var canvas = createCanvas(div.id, "canevas_summary_2_"+i*2);
                graphYear = createGraph(lineName + " Summary Years ", canvas, yearLevelData[0][0], years);
                yearLevelData.forEach(element => {
                    if(element[2][2]!= 0 && element[2][1]==levelTr[1]-1 && element[2][0]==levelTr[0]-1){
                        addDataset(graphYear, element[0], element[1]);
                    }
                });
                var div = createDiv("graphCell_"+i+"_1", "container_summary_2_"+i*2+1);
                var canvas = createCanvas(div.id, "canevas_summary_2_"+i*2+1);
                graphMonth = createGraph(lineName + " Summary Months ", canvas, monthLevelData[0][0], months);
                monthLevelData.forEach(element => {
                    if(element[2][2]!= 0 && element[2][1]==levelTr[1]-1 && element[2][0]==levelTr[0]-1){
                        addDataset(graphMonth, element[0], element[1]);
                    }
                });
            }

        }*/
        
        yearLevelData.push([yearsData, lineName,levelTr] );
        monthLevelData.push([monthsData, lineName,levelTr] );
    }

}


function addDataset(graph, data, label){
    var newDataset = {
        label: label,
        data: data
    };
    graph.config.data.datasets.push(newDataset);
}


function table2csv(name,devSym){

    var data = $('#data').data("toShow");
    var years = $('#data').data("years");
    var months = $('#data').data("months");
    var uc = getUcSelected();

    for(let i =0; i< data.length; i++){       
        if(data[i][0]==uc){
            ucData = data[i].slice(1, data[i].length);
        }
    }

    iMax = ucData[0].length;
    jMax = ucData.length;
    csv = ";";
    for(let j = 0; j < jMax; j++){
        csv += $("#"+j).text() + ";";
    }
    csv += "\n";
    for(let i = 0; i < iMax; i++){
        var lineName = $("#"+"lineName_"+i).text() 
        csv += lineName +";";
        for(let j = 0; j < jMax; j++){
            csv += ucData[j][i] + ";";
        }
        csv += "\n";
    }
    var hiddenElement = document.createElement('a');
    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
    hiddenElement.target = '_blank';
    hiddenElement.download = name+'.csv';
    hiddenElement.click(); 
}




