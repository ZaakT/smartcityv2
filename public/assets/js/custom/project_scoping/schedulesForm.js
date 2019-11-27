function searchUCids(){
    var list_ucs = [];
    $("#schedules_implem div").each(function(){
        var id = $(this).attr('id');
        var tab = id.split('_');
        //console.log(tab);
        var id_uc = parseInt(tab[2]);
        //console.log(id_compo,id_uc,id_zone);
        if(!list_ucs.includes(id_uc)){
            list_ucs.push(id_uc);
        }
    });
    //console.log(list_ucs);
    return list_ucs;
}

function initDatepickers(){
    list_parts.forEach((part) => {
        dates_saved[part]={};
        list_ucs.forEach((uc) => {
            dates_saved[part][uc]={};
            list_dates.forEach((date) => {
                dates_saved[part][uc][date] = "";
                if($("#"+part+"_"+date+"_"+uc).length > 0){
                    $("#"+part+"_"+date+"_"+uc).datepicker( {
                        format: "mm/yyyy",
                        startView: "months", 
                        minViewMode: "months",
                    })
                    .on('changeDate', function(ev){
                        //var newDate = new Date(ev.date);
                        var newDate = $("#"+part+"_"+date+"_"+uc).data('datepicker').date;
                        //console.log(newDate);
                        dates_saved[part][uc][date] = newDate;
                        checkValidity(part,uc,list_dates,dates_saved);
                    });  
                }      
            });  
        });   
    });
}

function checkValidity(part,uc,list_dates,dates_saved){
    var prec_date = new Date();
    var current_date = new Date();
    prec_date = dates_saved[part][uc]["startdate"];
    current_date = dates_saved[part][uc]["startdate"];
    var ret = true;

    list_dates.forEach((date) => {
        //console.log(dates_saved[part][uc][date]);
        if(date!="startdate"){
            current_date = dates_saved[part][uc][date];
            if(current_date!=""){
                if(current_date > prec_date){
                    $("#"+part+"_"+date+"_"+uc+" input").css("background","palegreen");
                } else {
                    $("#"+part+"_"+date+"_"+uc+" input").css("background","salmon");
                    ret = false;
                }
                prec_date = dates_saved[part][uc][date];
            } else {
                $("#"+part+"_"+date+"_"+uc+" input").css("background","salmon");
                ret = false;
            }
        } else {
            if(current_date!=""){
                $("#"+part+"_"+date+"_"+uc+" input").css("background","palegreen");
                prec_date = dates_saved[part][uc][date];
            } else {
                $("#"+part+"_"+date+"_"+uc+" input").css("background","salmon");
                ret = false;
            }
        }
        if(part=="implem" && date=="enddate"){
            ret = true;
        }
    });
    return ret;
}

function fullCheckValidity(){
    for(i in list_parts) {
        var part = list_parts[i];
        for(j in list_ucs) {
            var uc = list_ucs[j];
            if(checkValidity(part,uc,list_dates,dates_saved)==false){
                if(part!="revenues"){
                    return false;
                }
            }
        }   
    }
    return true;
}

function initColor(formName){
    $("#"+formName+" input").each(function(){
        var val = $(this).val();
        if(val.length <= 0){
            $(this).css("background","salmon");
        }
    });
}

function initSelDates(formName){
    $("#"+formName+" input").each(function(){
        var placeholder = $(this).attr('placeholder');
        var id = $(this).attr('id');
        var tab = id.split("_");
        var part = tab[1];
        var date = tab[2];
        var id_uc = tab[3];
        //console.log(part,date,id_uc);
        if(placeholder != undefined){
            //console.log(placeholder);
            $(this).val(placeholder);
            dates_saved[part][id_uc][date] = placeholder;
            checkValidity(part,id_uc,list_dates,dates_saved)
        }
    });
}

$.date = function(dateObject) {
    var d = new Date(dateObject);
    var day = d.getDate();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }
    var date = month + "/" + year;

    return date;
};

function copy_dates(part,id_prec,id_next){
    var list_to_copy = dates_saved[part][id_prec];
    console.log(list_to_copy);
    for (date_label in list_to_copy) {
        date = list_to_copy[date_label];
        console.log(date);
        if(date != "" > 0){
            dates_saved[part][id_next][date_label] = date;
            var temp = date.split("/");
            console.log(temp);
            var formattedDate = $.date(temp[0]+"/01/"+temp[1]);
            console.log(formattedDate);
            $("#"+part+"_"+date_label+"_"+id_next+" input").val(formattedDate);
            //$("#"+part+"_"+date_label+"_"+id_next).data('update',date);
        }
    }
    checkValidity(part,id_next,list_dates,dates_saved);
}

function erase_dates(part,uc){
    for(i in list_dates){
        var date = list_dates[i];
        //console.log(date);
        $("#"+part+"_"+date+"_"+uc+" input").val(" ");
        dates_saved[part][uc][date] = "";

    }
    checkValidity(part,uc,list_dates,dates_saved);
}

dates_saved = {};
list_ucs = searchUCids();
list_dates = ["startdate","25date","50date","75date","100date","enddate"];
list_parts = ["implem","opex","revenues"];
initDatepickers();
initColor("form_schedule");
initSelDates("form_schedule");