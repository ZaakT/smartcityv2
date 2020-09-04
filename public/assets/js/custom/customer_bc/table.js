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
    while (tableRef.rows.length > 1) {
        tableRef.deleteRow(1);
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



function updateGraph(ucData){
    ucData.forEach(item => {
        
    });

    
}
function updateData(){
    var data = $('#data').data("toShow");
    var ucSeleted = getUcSelected();
    var tableRef = document.getElementById('cball_table').getElementsByTagName('tbody')[0];
    updateTable(tableRef,data[ucSeleted] );
    updateGraph(data[ucSeleted]);


}

updateData();