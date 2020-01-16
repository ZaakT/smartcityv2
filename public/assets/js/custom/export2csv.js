
function download_csv(name="notitle",labels=[],data=[]) {
    var csv = "";
    for (const key in labels) {
        if (labels.hasOwnProperty(key)) {
            const label = labels[key];
            if(key < labels.length - 1){
                csv += label+";";
            } else {
               csv += label;
            }
        }
    }
    csv += "\n";
    data.forEach(function(row) {
            csv += row.join(';');
            csv += "\n";
    });
 
    //console.log(csv);
    var hiddenElement = document.createElement('a');
    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
    hiddenElement.target = '_blank';
    hiddenElement.download = name+'.csv';
    hiddenElement.click();
}