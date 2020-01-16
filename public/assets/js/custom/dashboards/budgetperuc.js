
function budgetperuc2csv(idTable,projName,ucName,selDevSym="£"){
    var text = "";
    var labels = [];
    var data = [];
    var name = "output_Budget_perUC_"+projName;
    labels.push("Project","Selected Use Case");

    if(idTable == "budget_uc_table"){
        $("#"+idTable+" thead tr").each(function(){
            $(this).children('th').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                labels.push(text);
            });
        });
        var i = 0;
        $("#"+idTable+" tbody tr").each(function(){
            if(i == 0){
                data.push([projName,ucName]);
            } else {
                data.push(["",""]);
            }
            $(this).children('td').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                data[i].push(text);
            });
            i++;
        });
    }
    //console.log(labels);
    //console.log(data);
    download_csv(name,labels,data)
}