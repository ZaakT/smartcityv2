function budgetalluc2csv(idTable,projName,selDevSym="£"){
    var text = "";
    var labels = [];
    var data = [];
    var name = "output_Budget_allUC_"+projName;
    labels.push("Project");

    if(idTable == "budget_all_table"){
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
                data.push([projName]);
            } else {
                data.push([""]);
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