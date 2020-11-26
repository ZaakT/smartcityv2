function showHide(object){
    if(object.hasAttribute("hidden")){
        object.removeAttribute('hidden')
    }else{
        object.setAttribute('hidden', true);
    }
}

function manageIndicator(indicatorID){
    $(".dep_"+indicatorID).each(function() {
        showHide(this);
    });
}

function drawGraphs(){
    compoData = $('#data').data("compo");
    projects = $('#data').data("projects");
    listCompo = $('#data').data("cat");
    bubbleData = $('#data').data("bubbleData");
    cat2Bubble = $('#data').data("catBubble");
    dataIndicator = $('#data').data("dataIndicator");
    console.log("hey");
    console.log(compoData);
    console.log(projects);
    console.log(listCompo);
    console.log(bubbleData);
    console.log(cat2Bubble);
    console.log(dataIndicator);
    console.log("hey");
    for(let i = 0; i < listCompo.length ; i++){
        data = [];
        names = [];
        idProjTab = Object.keys(compoData);
        for(let j = 0; j<idProjTab.length; j++){
            data.push(compoData[idProjTab[j]][listCompo[i]]);
            names.push(projects[idProjTab[j]]['name']);
        }
        updateBarChart(data, names, "comp_graph_"+i);
    }

    for(let i = 0; i<cat2Bubble.length; i++){
        data = [];
        names = [];
        keys = [];
        idProjTab = Object.keys(bubbleData);
        for(let j = 0; j<idProjTab.length; j++){
            data.push(bubbleData[idProjTab[j]][i]);
            names.push(projects[idProjTab[j]]['name']);
        }
        updateBubbleChart(data, names, "comp_bubble_"+i, dataIndicator, cat2Bubble[i]);

    }



}


function updateBubbleChart(data, names, idCanvas, dataIndicator, indicators){
    console.log(dataIndicator)

    var popCanvas = document.getElementById(idCanvas);
    dataset = []
    colors = getColorsArray(data);
    for(infoID in data){
        keys = Object.keys(data[infoID]);
        dataset.push({data: [{x: data[infoID][keys[0]], y: data[infoID][keys[1]], r: 10, label: infoID }],
            label : infoID + ": " + names[infoID],
            backgroundColor: colors[0][infoID],
            borderColor : colors[1][infoID]
        })
    }
    //dataset.push({x: 0, y: 0, r: 0, label: "" })
    


    var popData = {
    datasets: dataset
    };

    var bubbleChart = new Chart(popCanvas, {
    type: 'bubble',
    data: popData,
    options: {
        legend: {
        display: true,//false
     },
       tooltips: {
        enabled: true,
          callbacks: {
             label: function(t, d) {
                return d.datasets[t.datasetIndex].label + 
                ' ('+dataIndicator[indicators[0]]["name"] +': ' + t.xLabel + ' '+ dataIndicator[indicators[1]]["unit"] +', '+dataIndicator[indicators[1]]["name"]+': ' + t.yLabel +' '+ dataIndicator[indicators[1]]["unit"] + ')';
             }
          }
       },
       scales: {
        yAxes: [{
            scaleLabel: {
              display: true,
              labelString: dataIndicator[indicators[1]]["name"] + ' (in '+dataIndicator[indicators[1]]["unit"]+')'
            }
        }],
        xAxes: [{
            scaleLabel: {
              display: true,
              labelString: dataIndicator[indicators[0]]["name"] + ' (in '+dataIndicator[indicators[0]]["unit"]+')'
            }
        }]
    }
    },
    
    });
    
}

function updateBarChart(data, names, idCanvas){
    colors = getColorsArray(data);
    //console.log(data);
    var chart = new Chart(idCanvas, {
        type: 'bar',
        data: {
            labels: names,
            datasets: [{
                data: data,
                borderWidth: 1,
                backgroundColor: colors[0],
                borderColor : colors[1]
            }]
        },
        options: {
            
            legend: {
                display : false
            },
            scales :{
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                    }
                }]
            }

        }
    });
}
