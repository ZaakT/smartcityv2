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


function updateData(){
    var data = $('#data').data("toShow");
    var ucSeleted = getUcSelected();
    var tableRef = document.getElementById('cball_table').getElementsByTagName('tbody')[0];
    while (tableRef.rows.length > 1) {
        tableRef.deleteRow(1);
      } 
    data[ucSeleted].forEach(row => {
        var newRow   = tableRef.insertRow();
        var i=0
        row.forEach(element => {
            var newCell  = newRow.insertCell(i);
            i++;
            newCell.appendChild(document.createTextNode(element));
        });
    });
}

updateData();