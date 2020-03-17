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

function submitForm(formName){
    $("#"+formName).submit();
}

function countSelectedImplem(oForm) {
    var i, n = 0;
    var oElement;
    for (i = 0; i < oForm.elements.length; i++) {
        oElement = oForm.elements[i];
        if (oElement.tagName.toLowerCase() == "input") {
            if (oElement.type.toLowerCase() == "checkbox") {
                if (oElement.checked == true) {
                    n++;
                }
            }
        }
    }
    $("#countImplemSelect").text(n+" selected");
    //console.log(n);
    if (n >= 1) {
        $("#help_implem").attr('hidden', 'hidden');
        return true;
    }
    else {
        $("#help_implem").removeAttr('hidden');
        return false;
    }
}
/*
function checkImplemInput(){
    var ret = true;
    $("#implem_input input").each(function(){
        var val = $(this).val();
        if($(this).classes().includes("volume")){
            val = val ? parseInt(val) : -1 ;
            //console.log(val);
            if(val < 0){
                $(this).css("background","salmon");
                $(this).val("");
                ret = false;
            } else {
                $(this).val(val);
                $(this).css("background","#C3E6CB");
            }
        } else if ($(this).classes().includes("unit_cost")){
            val = val ? parseFloat(val) : -1 ;
            var temp = String(val).split(".");
            if(val < 0.){
                $(this).css("background","salmon");
                $(this).val("");
                ret = false;
            } else if (temp.length==2 && temp[1].length>3){
                $(this).css("background","salmon");
                ret = false;
            } else {
                //$(this).val(val);
                $(this).css("background","#C3E6CB");
            }
        }
    });
    calcTotImplem();
    return ret;
} */


function checkImplemInput(id){
    var ret = true;
    id = id.getAttribute('id');
    //console.log(id);
    var val = $("#"+id).val();
    //console.log(val);
    var tab = $("#"+id).classes();
    if(tab.includes("volume")){
        val = val ? parseInt(val) : -1 ;
        //console.log(val);
        if(val < 0){
            $("#"+id).css("background","salmon");
            $("#"+id).val("");
            ret = false;
        } else {
            $("#"+id).val(val);
            $("#"+id).css("background","#C3E6CB");
            //changer la valeur de volume ratio correspondante
            var volume = val;
            var nb_uc = $("#nb_uc").html();
            ratio = Math.round(volume / nb_uc);
            //console.log(ratio);
            id = id.split("_");
            //console.log("rat_"+id[1]);
            $("#rat_"+id[1]).val(ratio);
            $("#rat_"+id[1]).each(function(){
                checkImplemInput(this);
            });
        }
    } else if (tab.includes("unit_cost")){
        val = val ? parseFloat(val) : -1 ;
        var temp = String(val).split(".");
        if(val < 0.){
            $("#"+id).css("background","salmon");
            $("#"+id).val("");
            ret = false;
        } else if (temp.length==2 && temp[1].length>3){
            $("#"+id).css("background","salmon");
            ret = false;
        } else {
            //$(this).val(val);
            $("#"+id).css("background","#C3E6CB");
        }
    } else if (tab.includes("ratio")){
        val = val ? parseFloat(val) : -1 ;
        var temp = String(val).split(".");
        if(val < 0.){
            $("#"+id).css("background","salmon");
            $("#"+id).val("");
            ret = false;
        } else if (temp.length==2 && temp[1].length>3){
            $("#"+id).css("background","salmon");
            ret = false;
        } else {
            //$(this).val(val);
            $("#"+id).css("background","#C3E6CB");
            //changer la valeur de volume correspondante
            var ratio = val;
            var nb_uc = $("#nb_uc").html();
            volume = Math.round(ratio * nb_uc);
            //console.log(volume);
            id = id.split("_");
            //console.log("vol_"+id[1]);
            $("#vol_"+id[1]).val(volume);
            $("#vol_"+id[1]).each(function(){
                checkImplemInput(this);
            });
        }
    } 

    calcTotImplem();
    return ret;
}

function calcTotImplem(){
    var sum = 0;
    $("#tot_table_implem td").each(function(){
        var id = $(this).attr('id');
        if (id){
            var temp = id.split("_");
            if (temp.length==2){
                var val1 = parseInt($("#vol_"+temp[1]).val());
                var val2 = parseFloat($("#cost_"+temp[1]).val());
                var tot = val1 && val2 ? val1*val2 : 0;
                $(this).text(tot.toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
                sum += tot;
            } else if (temp.length==1) {
                $(this).text(sum.toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
            }
        }
    });
}

function setNewDeviseImplem(name){
    deviseName = name;
    try{
        countSelectedImplem(form_implem);
    } catch {
        //do nothing
    } finally { 
        $("#implem_input input").each(function(){
            checkImplemInput(this);
        });
        calcTotImplem();
    }
}

setNewDeviseImplem("GBP");
