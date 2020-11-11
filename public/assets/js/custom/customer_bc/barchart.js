



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

function updateBarChart(ucData, idCanvas){
    data = [];
    names = [];
    
    
    
    ucData.forEach(element => {
        data.push(element[1]);
        names.push(element[0]);
    });
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
                        max: 10
                    }
                }]
            }

        }
    });
}

function updateData(){ 
    var data = $('#data').data("toShow");
    $("#barchart").remove();
    console.log(data[getUcSelected()]);
    if(data[getUcSelected()].length==0){
        $("#errorInput").text("Error: No Item selected for This use case, please go to the Input Use Case section.");
      }else{
        $("#errorInput").text("");
        $('#graph-container').append('<canvas id="barchart"><canvas>');
        updateBarChart(data[getUcSelected()], "barchart");
      }
}


updateData();