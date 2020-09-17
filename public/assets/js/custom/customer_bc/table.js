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

function delAllRows(tableRef){
    while (tableRef.rows.length > 0) {
        tableRef.deleteRow(0);
      } 
}

function updateTable(tableRef,ucData ){
    delAllRows(tableRef);
    ucData.forEach(item => {
        var newRow   = tableRef.insertRow();
        var i=0
        item.forEach(element => {
            var newCell  = newRow.insertCell(i);
            i++;
            newCell.appendChild(document.createTextNode(element));
        });
    });
}

function createCanvas(idDiv, idCanvas){
    canvas = document.createElement('canvas');
    div = document.getElementById(idDiv);
    canvas.id     = idCanvas;  
    canvas.style.width='100%';
    canvas.style.height='100%';
    canvas.style = "height: 100%; width: 100%;";     
    div.appendChild(canvas);
    return canvas;
}

function createGraph(title, father, x, y, currency="£"){
    //console.log("id :"+father.id);
    var chart= new  Chart(father.id, {
        type: 'line',
        data: {
          labels: y,
          datasets: [{ 
            data: x,
            label: title,
            borderColor: "#55D8FE",
            backgroundColor: "#55D8FE",
            fill: false
          }
          ]
        },
        options: {
            responsive:true,
            maintainAspectRatio: true,
          scales: {
              yAxes: [{
                  scaleLabel: {
                    display: true,
                  labelString: 'Cash (in '+currency+')'
                  },
                  ticks: {
                      callback: function(value, index, values) {
                          if (parseInt(value) >= 1000||parseInt(value) <= -1000) {
                              return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                          } else {
                              return value;
                          }
                      }
                  }          
              }],
              /*xAxes: [{
                scaleLabel:{
                    display = true,
                    labelString: 'Year'
                }
                
              }]*/
            },    

          title: {
            display: false
          },
          plugins: {
            datalabels: {
              display: false
            }
          }
        }
      }); 
    chart.resize();
    return chart;
}
function createDiv(idFather, idDiv){
    div = document.createElement('div');
    father = document.getElementById(idFather);
    div.id     = idDiv;
    div.width  = 300 ;
    div.height = 300;   
    div.style = "height: 300px; width: 95%; margin: 1em;";     
    div.style.zIndex   = 8;
    father.appendChild(div);
    return div;
}

function removeGraphs(){
  var containers = document.querySelectorAll('[id ^= "container_"]');
  containers.forEach(item => {
    item.remove();
  })
}
function updateGraph(ucData, years){
    var currency = $("#currency").text();
    var i=0
    removeGraphs();
    ucData.forEach(item => {
        //console.log(item[0], item.slice(1), years, currency);
        var div = createDiv("graph", "container_"+i);
        var canvas = createCanvas(div.id, "canevas_"+i);
        createGraph(item[0], canvas, item.slice(1), years, currency);
        i++;
    });

    
}
function updateData(){
    var data = $('#data').data("toShow");
    var years = $('#data').data("years");
    var ucSeleted = getUcSelected();
    var tableRef = document.getElementById('cball_table').getElementsByTagName('tbody')[0];
    //console.log(data[getUcSelected()]);
    //console.log("coucou");
    if(data[getUcSelected()].length==0){
      $("#errorInput").text("Error: Any Item selected for This use case, please go to the Input Use Case section.");
      removeGraphs();
      updateTable(tableRef,data[ucSeleted] );
      $("#cball_table").attr('hidden', true);

    }else{
      $("#errorInput").text("");
      $("#cball_table").removeAttr('hidden');
      updateTable(tableRef,data[ucSeleted] );
      updateGraph(data[ucSeleted], years);
    }


}

updateData();