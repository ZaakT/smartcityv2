;!(function ($) {
    $.fn.classes = function (callback) {
        var classes = [];
        $.each(this, function (i, v) {
            var splitClassName = v.className.split(/\s+/);
            for (var j = 0; j < splitClassName.length; j++) {
                var className = splitClassName[j];
                if (-1 === classes.indexOf(className)) {
                    classes.push(className);
                }
            }
        });
        if ('function' === typeof callback) {
            for (var i in classes) {
                callback(classes[i]);
            }
        }
        return classes;
    };
})(jQuery);

function countChecked_zones(formName){
    var nb_selectedZones = 0;
    $("#"+formName).each(function(){
        var j = 1;
        while($(".level_"+j).length!=0){
            var nb_hasChildren_checked = 0;
            var nb_checked = 0;
            $('.level_'+j).find('tr').each(function(){
                var tab = $(this).classes();
                var hasChildren = tab.includes("hasChildren");
                var input = $(this).find('input');
                var id_input = input.attr('id');
                if(id_input!=undefined){
                    if(input.prop('checked')){
                        nb_checked++;
                        $(".child_"+id_input).removeAttr("hidden");
                        if(hasChildren){
                            nb_hasChildren_checked++;
                            $('.level_'+(j+1)).removeAttr("hidden");
                        }
                    } else {
                        $(".child_"+id_input).find('input').prop("checked",false);
                        $(".child_"+id_input).attr("hidden","hidden");
                        if(nb_checked<=0){
                            $('.level_'+(j+1)).attr("hidden","hidden");
                        }
                    }
                }
            });
            j++;
            nb_selectedZones += nb_checked-nb_hasChildren_checked;
        }
    });
    //console.log(nb_selectedZones);
    $("#countZonesSelect").text(nb_selectedZones+" selected")
    if (nb_selectedZones > 0) {
        $("#help_zones").attr('hidden', 'hidden');
        return true;
    }
    else {
        $("#help_zones").removeAttr('hidden');
        return false;
    }
}

countChecked_zones("form_cbuc");

function cbuc2csv(idTable,projName,ucName,selDevSym="£"){
    var text = "";
    var labels = [];
    var data = [];
    var name = "output_CB_perUC_"+projName;
    labels.push("Selected Zones","Project","Selected Use Case");
    $("#selected_zones").each(function(){
        text = $(this).text();
        text = text.replace(/\n/g,"");
        text = text.replace(/\s{2,}/g, "");
        //text = text.replace(/\s{1}$/, "");
        var zones = text.split("/");
        //console.log(zones);
        for (const key in zones) {
            if (zones.hasOwnProperty(key)) {
                const zone = zones[key];
                data.push([zone]);
            }
        }
    });

    if(idTable == "cbuc_table"){
        name += "_summary";
        var j = 0;
        $("#cbuc_table thead tr").each(function(){
            if(j != 0){
                $(this).children('th').each(function(){
                    text = $(this).text();
                    text = text.replace(selDevSym+" ",'');
                    labels.push(text);
                });
            }
            j++;
        });
        var i = 0;
        $("#cbuc_table tbody tr").each(function(){
            if(i == 0){
                data[0].push(projName,ucName);
            } else {
                if(data.hasOwnProperty(i)){
                    data[i].push("","");
                } else {
                    data.push(["","",""]);
                }
            }
            $(this).children('td').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                data[i].push(text);
            });
            i++;
        });
    } else if(idTable == "keydates_table"){
        name += "_keydates";
        labels.push("Date Label (Project)");
        labels.push("Date (Project)");
        labels.push("Date Label (Selected Use Case)");
        labels.push("Date (Selected Use Case)");
        var i = 0;
        $("#keydates_table tbody tr").each(function(){
            if(i == 0){
                data[0].push(projName,ucName);
            } else {
                if(data.hasOwnProperty(i)){
                    data[i].push("","");
                } else {
                    data.push(["","",""]);
                }
            }
            $(this).children('td').each(function(){
                text = $(this).text();
                text = text.replace(selDevSym+" ",'');
                data[i].push(text);
            });
            i++;
        });

    } else if(idTable == "keyratios_table"){
        name += "_keyratios";
        labels.push("Ratio Label");
        labels.push("Ratio Value");
        var i = 0;
        $("#keyratios_table tbody tr").each(function(){
            if(i == 0){
                data[0].push(projName,ucName);
            } else {
                if(data.hasOwnProperty(i)){
                    data[i].push("","");
                } else {
                    data.push(["","",""]);
                }
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