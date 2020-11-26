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
    bubbleName = $('#data').data("bubbleName");
    cat2Bubble = $('#data').data("catBubble");
    console.log(compoData);
    console.log(bubbleName);
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
        updateBubbleChart(data, names, "comp_bubble_"+i, bubbleName[i]);

    }



}


function updateBubbleChart(data, names, idCanvas, bubbleName){

    var popCanvas = document.getElementById(idCanvas);
    dataset = []
    colors = getColorsArray(data);
    for(infoID in data){
        keys = Object.keys(data[infoID]);
        dataset.push({x: data[infoID][keys[0]], y: data[infoID][keys[1]], r: 50, label: names[infoID] })
    }
    dataset.push({x: 0, y: 0, r: 0, label: "" })
    var popData = {
    datasets: [{
        label : ["label 1", "label 2"],
        data: dataset,
        backgroundColor: colors[0],
        borderColor : colors[1]
    }]
    };

    var bubbleChart = new Chart(popCanvas, {
    type: 'bubble',
    data: popData,
    options: {
        legend: {
        display: false
     },
       tooltips: {
        enabled: false,
          callbacks: {
             label: function(t, d) {
                return "";
             }
          }
       },
       scales: {
        yAxes: [{
            scaleLabel: {
              display: true,
              labelString: bubbleName[1]
            }
        }],
        xAxes: [{
            scaleLabel: {
              display: true,
              labelString: bubbleName[0]
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
