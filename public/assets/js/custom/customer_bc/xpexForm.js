
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


function monthDiff(d1, d2)
{
    month1 = parseInt(d1.split("-")[1]);
    year1 = parseInt(d1.split("-")[0]);

    month2 = parseInt(d2.split("-")[1]);
    year2 = parseInt(d2.split("-")[0]);
    return (year2-year1)*12 + month2-month1;
}

function submitForm(formName){
    $("#"+formName).submit();
}

function countSelectedXpex(oForm) {
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
    $("#countXpexSelect").text(n+" selected");
    //console.log(n);
    if (n >= 1) {
        $("#help_xpex").attr('hidden', 'hidden');
        return true;
    }
    else {
        $("#help_xpex").removeAttr('hidden');
        return false;
    }
}

function checkXpexInput(id, idAlert){
    console.log("checkXpexInput()");
    var ret = true;
    id = id.getAttribute('id');
    var val = $("#"+id).val().toString();
    console.log(id);
    var tab = $("#"+id).classes();
    var revenue_start = $("#pricing_start").text();
    var uc_end = $("#uc_end").text();
    if(tab.includes("volume")){
        //console.log(tab);
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
        } 
    } else if (tab.includes("unitCost") || tab.includes("period") || tab.includes("unitRev") || tab.includes("currentRevenues")  ){
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
            //$("#"+id).val(val);
            $("#"+id).val(val);
            $("#"+id).css("background","#C3E6CB");
        }
    } else if(tab.includes("anVarCost") || tab.includes("anVarVol") || tab.includes("anVarRev") || tab.includes("volRed") || tab.includes("unitCostRed")){
        val = val ? parseFloat(val) : 0 ;

        if(val > 100){
            $("#"+id).css("background","salmon");
            $("#"+id).val("");
            ret = false;
        } else {
            //$("#"+id).val(val);
            $("#"+id).val(val);
            $("#"+id).css("background","#C3E6CB");
        } 
    }else if(tab.includes("unit") || tab.includes("guide")){

        $("#"+id).val(val);
        $("#"+id).css("background","#C3E6CB");

    }else if(tab.includes("impact100")){
        val = val ? parseInt(val) : -1 ;
        if(val < 0){
            $("#"+id).css("background","salmon");
            $("#"+id).val("");
            ret = false;
        } else if(val > 100) {
            $("#"+id).css("background","salmon");
            ret = false;
        } else {
            $("#"+id).val(val);
            $("#"+id).css("background","#C3E6CB");
        }
    }else if(tab.includes("impact")){
        val = val ? parseInt(val) : -1 ;
        console.log("dans impact");
        if(val <= 0){
            $("#"+id).css("background","salmon");
            $("#"+id).val("");
            ret = false;
        } else if(val > 10) {
            $("#"+id).css("background","salmon");
            ret = false;
        } else {
            $("#"+id).val(val);
            $("#"+id).css("background","#C3E6CB");
        }
    } else if (tab.includes("prob")){
        console.log("dans prob")
        val = val ? parseFloat(val) : -1 ;
        var temp = String(val).split(".");
        if(val < 0.){
            $("#"+id).css("background","salmon");
            $("#"+id).val("");
            ret = false;
        } else if (temp.length==2 && temp[1].length>3){
            $("#"+id).css("background","salmon");
            ret = false;
        } else if(val > 100) {
            $("#"+id).css("background","salmon");
            ret = false;
        } else {
            //$("#"+id).val(val);
            $("#"+id).val(val);
            $("#"+id).css("background","#C3E6CB");
        }
      

    } else if(tab.includes("revenueStart")){
        if(val == "" || monthDiff(val, revenue_start)>0  || monthDiff(val, uc_end)<0){
            $("#"+id).css("background","salmon");
            $("#"+id).val("");
            ret = false;
            if(val != ""){
                addAlert("The start of revenue has to be beetwen "+revenue_start+" and "+uc_end+".", idAlert);
                idAlert++;
            }
        } else {
            //$(this).val(val);
            $("#"+id).val(val);
            $("#"+id).css("background","#C3E6CB");
        }

    }else if(tab.includes("rampUpDurationt")){
        if(val == ""){
            $("#"+id).css("background","salmon");
            $("#"+id).val("");
            ret = false;
        } else if($("#revenueStart_"+id.split("_")[1]).val()!=""){
            if(monthDiff( uc_end, $("#revenueStart_"+id.split("_")[1]).val())>-val){
                $("#"+id).css("background","salmon");
                $("#"+id).val("");
                addAlert("Revenuses must end before the Use Case ("+uc_end+").", idAlert);
                idAlert++;
                ret = false;
            }
            else{
            $("#"+id).val(val);
            $("#"+id).css("background","#C3E6CB");
            }
        }else{
            $("#"+id).val(val);
            $("#"+id).css("background","#C3E6CB");
        }

    }
    calcTotXpex();
    return [idAlert, ret];
}

function calcTotXpex(){
    $("#xpex_table td").each(function(){
        var id = $("#"+id).attr('id');
        if (id){
            var temp = id.split("_");
            if (temp[0]=="cost"){

                var val1 = parseInt($("#vol_"+temp[1]).val());
                var val2 = parseFloat($("#unitCost_"+temp[1]).val());
                var tot = val1 && val2 ? val1*val2 : 0;
                $("#"+id).text(tot.toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
            } 
            
        }
    });
}

function checkXpexAll(){
    idAlert = 0;
    ret = true;
    $("input").each(function(){
        res = checkXpexInput(this, idAlert);
        idAlert = res[0];
        ret = ret && res[1];
    });
    $("textarea").each(function(){
        res = checkXpexInput(this, idAlert);
        idAlert = res[0];
        ret = ret && res[1];
    });
    calcTotXpex();
    return ret;
}

function setNewDeviseXpex(name){
    deviseName = name;
    try{
        countSelectedXpex(form_xpex);
    } catch {
        //do nothing
    } finally {
        checkXpexAll();
    }
}

function hide(id){
    $(".cat_"+id).each(function(){
        if(this.hasAttribute("hidden")){
            this.removeAttribute("hidden");
        }else{
            this.setAttribute("hidden", true);
        }
    });
}

setNewDeviseXpex("GBP");

