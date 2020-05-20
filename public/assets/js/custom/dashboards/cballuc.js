
/* function cballuc2csv(idTable,projName,selDevSym="£"){
    var text = "";
    var labels = [];
    var data = [];
    var name = "output_CB_allUC_"+projName;
    labels.push("Project");
    if(idTable == "cball_table"){
        name += "_summary";
        $("#cball_table thead th").each(function(){
            text = $(this).text();
            labels.push(text);
        });
        var i = 0;
        $("#cball_table tbody tr").each(function(){
            if(i == 0){
                data.push([projName]);
            } else {
                data.push([""]);
            }
            i++;
            $(this).children('td').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                data[data.length-1].push(text);
            });
        });
    } else if(idTable == "keydates_table"){
        name += "_keydates";
        labels.push("Date Label");
        labels.push("Date");
        var i = 0;
        $("#keydates_table tbody tr").each(function(){
            if(i == 0){
                data.push([projName]);
            } else {
                data.push([""]);
            }
            i++;
            $(this).children('td').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                data[data.length-1].push(text);
            });
        });

    } else if(idTable == "keyratios_table"){
        name += "_keyratios";
        labels.push("Ratio Label");
        labels.push("Ratio Value");
        var i = 0;
        $("#keyratios_table tbody tr").each(function(){
            if(i == 0){
                data.push([projName]);
            } else {
                data.push([""]);
            }
            i++;
            $(this).children('td').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                data[data.length-1].push(text);
            });
        });
        
    }
    //console.log(labels);
    //console.log(data);
    download_csv(name,labels,data)
} */