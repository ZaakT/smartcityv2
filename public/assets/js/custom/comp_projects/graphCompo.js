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
    for(let i = 0; i < listCompo.length ; i++){
        data = [];
        names = [];
        idProjTab = Object.keys(compoData);
        for(let j = 0; j<idProjTab.length; j++){
            console.log(idProjTab[j], listCompo[i])
            data.push(compoData[idProjTab[j]][listCompo[i]]);
            names.push(projects[idProjTab[j]]['name']);
        }
        updateBarChart(data, names, "comp_graph_"+i);
    }
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
