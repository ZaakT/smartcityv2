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

function countSelectedWiderCash(oForm) {
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
    $("#countWiderCashSelect").text(n+" selected");
    //console.log(n);
    if (n >= 1) {
        $("#help_widercash").attr('hidden', 'hidden');
        return true;
    }
    else {
        $("#help_widercash").removeAttr('hidden');
        return false;
    }
}

function checkWiderCashInput(){
    var ret = true;
    $("#widercash_input input").each(function(){
        var val = $(this).val();
        var tab = $(this).classes();
        if(tab.includes("volume")){
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
        } else if (tab.includes("unitCost") || tab.includes("anVarVol") || tab.includes("anVarCost") || tab.includes("volRed") || tab.includes("unitCostRed")){
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
        } else if (tab.includes("unitIndic")){
            //console.log(val);
            if(val == ""){
                $(this).css("background","salmon");
                ret = false;
            } else {
                //$(this).val(val);
                $(this).css("background","#C3E6CB");
            }
        }
    });
    calcTotWiderCash();
    return ret;
}

function calcTotWiderCash(){
    var sum_bc = 0;
    var sum_crt = 0;
    var sum_crb = 0;
    $("#tot_table td").each(function(){
        var id = $(this).attr('id');
        if (id){
            var temp = id.split("_");
            if (temp.length==3){
                if(temp[1]=="bc"){
                    var vol = parseInt($("#vol_"+temp[2]).val());
                    var unitCost = parseFloat($("#unitCost_"+temp[2]).val());
                    var tot = vol && unitCost ? vol*unitCost : 0;
                    $(this).text(tot.toLocaleString(undefined,{maximumFractionDigits:2}));
                    sum_bc += tot;
                } else if(temp[1]=="crt"){
                    var vol = parseInt($("#vol_"+temp[2]).val());
                    var unitCost = parseFloat($("#unitCost_"+temp[2]).val());
                    var bc = vol && unitCost ? vol*unitCost : 0;
                    var vol_red = parseFloat($("#volRed_"+temp[2]).val());
                    var cost_red = parseFloat($("#unitCostRed_"+temp[2]).val());
                    var tot = bc&&vol_red&&cost_red ? bc*(100-vol_red)*(100-cost_red)/1E4 : 0;
                    //console.log(tot);
                    $(this).text(tot.toLocaleString(undefined,{maximumFractionDigits:2}));
                    sum_crt += tot;
                } else if(temp[1]=="crb"){
                    var vol = parseInt($("#vol_"+temp[2]).val());
                    var unitCost = parseFloat($("#unitCost_"+temp[2]).val());
                    var bc = vol && unitCost ? vol*unitCost : 0;
                    var vol_red = parseFloat($("#volRed_"+temp[2]).val());
                    var cost_red = parseFloat($("#unitCostRed_"+temp[2]).val());
                    var crt = bc&&vol_red&&cost_red ? bc*(100-vol_red)*(100-cost_red)/1E4 : 0;
                    var tot = bc-crt;
                    $(this).text(tot.toLocaleString(undefined,{maximumFractionDigits:3}));
                    sum_crb += tot;
                } else if(temp[1]=="varvol"){
                    var val = parseFloat($("#anVarVol_"+temp[2]).val());
                    var tot = val ? val/12/100 : 0;
                    $(this).text(tot.toLocaleString(undefined,{style:"percent",maximumFractionDigits:2}));
                } else if(temp[1]=="varcost"){
                    var val = parseFloat($("#anVarCost_"+temp[2]).val());
                    var tot = val ? val/12/100 : 0;
                    $(this).text(tot.toLocaleString(undefined,{style:"percent",maximumFractionDigits:2}));
                } else if(temp[1]=="combvar"){
                    var varvol = parseFloat($("#anVarVol_"+temp[2]).val());
                    varvol = varvol ? varvol/12/100 : 0;
                    var varcost = parseFloat($("#anVarCost_"+temp[2]).val());
                    varcost = varcost ? varcost/12/100 : 0;

                    var tot = varvol && varcost ? varvol+varcost : 0;
                    $(this).text(tot.toLocaleString(undefined,{style:"percent",maximumFractionDigits:2}));
                }
            } else if (temp.length==2) {
                if(temp[1]=="bc"){
                    $(this).text(sum_bc.toLocaleString(undefined,{maximumFractionDigits:3}));
                } else if(temp[1]=="crt"){
                    $(this).text(sum_crt.toLocaleString(undefined,{maximumFractionDigits:3}));
                } else if(temp[1]=="crb"){
                    $(this).text(sum_crb.toLocaleString(undefined,{maximumFractionDigits:3}));
                }
            }
        }
    });
}


try{
    countSelectedWiderCash(form_widercash);
} catch {
    //do nothing
} finally {
    checkWiderCashInput();
    calcTotWiderCash();
}