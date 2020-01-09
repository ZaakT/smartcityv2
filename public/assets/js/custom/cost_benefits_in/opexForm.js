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

function countSelectedOpex(oForm) {
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
    $("#countOpexSelect").text(n+" selected");
    //console.log(n);
    if (n >= 1) {
        $("#help_opex").attr('hidden', 'hidden');
        return true;
    }
    else {
        $("#help_opex").removeAttr('hidden');
        return false;
    }
}

function checkOpexInput(){
    var ret = true;
    $("#opex_input input").each(function(){
        var val = $(this).val();
        var tab = $(this).classes()
        if(tab.includes("volume")){
            val = val ? parseInt(val) : -1 ;
            //console.log(val);
            if(val < 0){
                $(this).css("background","salmon");
                $(this).val("");
                ret = false;
            } else {
                $(this).val(val);
                $(this).css("background","palegreen");
            }
        } else if (tab.includes("unit_cost") || tab.includes("anVarVol") || tab.includes("anVarCost")){
            //console.log(val);
            val = val ? parseFloat(val) : -1 ;
            //console.log(val);
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
                $(this).css("background","palegreen");
                //$(this).val(val.toLocaleString(undefined));
            }
        }
    });
    calcTotOpex();
    return ret;
}

function calcTotOpex(){
    var sum = 0;
    $("#tot_table_opex td").each(function(){
        var id = $(this).attr('id');
        if (id){
            var temp = id.split("_");
            if (temp.length==3){
                if(temp[1]=="cost"){
                    var val1 = parseInt($("#vol_"+temp[2]).val());
                    var val2 = parseFloat($("#cost_"+temp[2]).val());
                    var tot = val1 && val2 ? 12*val1*val2 : 0;
                    $(this).text(tot.toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
                    sum += tot;
                } else if(temp[1]=="varvol"){
                    var val = parseFloat($("#anVarVol_"+temp[2]).val());
                    var tot = val ? val/100 : 0;
                    $(this).text(tot.toLocaleString(undefined,{style:"percent",maximumFractionDigits:3}));
                } else if(temp[1]=="varcost"){
                    var val = parseFloat($("#anVarCost_"+temp[2]).val());
                    var tot = val ? val/100 : 0;
                    $(this).text(tot.toLocaleString(undefined,{style:"percent",maximumFractionDigits:3}));
                } else if(temp[1]=="combvar"){
                    var varvol = parseFloat($("#anVarVol_"+temp[2]).val());
                    varvol = varvol ? varvol/100 : 0;
                    var varcost = parseFloat($("#anVarCost_"+temp[2]).val());
                    varcost = varcost ? varcost/100 : 0;
                    var tot = varvol && varcost ? varvol+varcost : 0;
                    $(this).text(tot.toLocaleString(undefined,{style:"percent",maximumFractionDigits:3}));
                }
            } else if (temp.length==2) {
                $(this).text(sum.toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
            }
        }
    });
}


function setNewDeviseOpex(name){
    deviseName = name;
    try{
        countSelectedOpex(form_opex);
    } catch {
        //do nothing
    } finally {
        checkOpexInput();
        calcTotOpex();
    }
}

setNewDeviseOpex("GBP");