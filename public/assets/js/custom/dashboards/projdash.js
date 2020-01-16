
function projdash2csv(idTable,projName,selDevSym="£"){
    var text = "";
    var labels = [];
    var data = [];
    var i = 0;
    var j = 0;
    var name = "output_"+projName+"_projectDashboard";
    labels.push("Project");

    if(idTable == "project_scope_table"){
        name += "_projectScope";
        i = 0;
        labels.push("");
        $("#"+idTable+" thead tr").each(function(){
            if(i!=0){
                $(this).children('th').each(function(){
                    text = $(this).text();
                    text = text.replace(selDevSym+" ",'');
                    labels.push(text);
                });
            }
            i++;
        });
        i = 0;
        $("#"+idTable+" tbody tr").each(function(){
            if(i == 0){
                data.push([projName]);
            } else {
                data.push([""]);
            }
            $(this).children('td').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                text = text.replace(/\n/g,'');
                text = text.replace("#",'nb of');
                data[i].push(text);
            });
            i++;
        });

    } else if(idTable == "budget_all_table"){
        name += "_budgetImpact";
        var i = 0;
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
    } else if(idTable == "cost_benefits_table"){
        name += "_CB";
        i = 0;
        $("#"+idTable+"2 tbody tr").each(function(){
            if(i == 0){
                data.push([projName]);
            } else {
                data.push([""]);
            }
            $(this).children('td').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                text = text.replace(/\n/g,'');
                data[i].push(text);
            });
            i++;
        });
        i = 0;
        $("#"+idTable+"1 tbody tr").each(function(){
            $(this).children('td').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                text = text.replace(/\n/g,'');
                data[i].push(text);
            });
            i++;
        });
        for (let i = 1; i < data[0].length; i++) {
            const list = data[i];
            if(i%2 == 0){
                labels.push("Value");
            } else {
                labels.push("Label");
            }
            
        }
    }
    //console.log(labels);
    //console.log(data);
    download_csv(name,labels,data);
}