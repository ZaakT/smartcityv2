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
            } else {
                $("#"+part+"_"+date+"_"+uc+" input").css("background","salmon");
                ret = false;
            }
            prec_date = dates_saved[part][uc][date];
        } else {
            if(current_date!=""){
                $("#"+part+"_"+date+"_"+uc+" input").css("background","palegreen");
            } else {
                $("#"+part+"_"+date+"_"+uc+" input").css("background","salmon");
                ret = false;
            }
        }
    });
    return ret;
}

function fullCheckValidity(){
    var ret = true
    list_parts.forEach((part) => {
        list_ucs.forEach((uc) => {
            if(checkValidity(part,uc,list_dates,dates_saved)==false){
                ret = false;
            }
        });   
    });
    return ret;
}

function initColor(formName){
    $("#"+formName+" input").each(function(){
        var val = $(this).val();
        if(val.length <= 0){
            $(this).css("background","salmon");
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
        if(date != "" > 0){
            var formattedDate = $.date(date);
            $("#"+part+"_"+date_label+"_"+id_next+" input").val(formattedDate);
            //$("#"+part+"_"+date_label+"_"+id_next).datepicker("setDate", "01/02/2012");
            $("#"+part+"_"+date_label+"_"+id_next).data('update',date);
            //$("#"+part+"_"+date_label+"_"+id_next).datepicker().trigger('changeDate');
        }
    }
    checkValidity(part,id_next,list_dates,dates_saved);
}

dates_saved = {};
list_ucs = searchUCids();
list_dates = ["startdate","25date","50date","75date","100date","enddate"];
list_parts = ["implem","opex","revenues"];
initColor("form_schedule");
initDatepickers();