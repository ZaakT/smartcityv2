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


/*
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
*/

function calcTotOpex(){
    var sum = [0, 0, 0 ,0];
    $("#tot_table_opex td").each(function(){
        var id = $(this).attr('id');
        if (id){
            var temp = id.split("_");
            if (temp.length==3){
                var varvol = parseFloat($("#anVarVol_"+temp[2]).val());
                varvol = varvol ? varvol/100 : 0;
                var varcost = parseFloat($("#anVarCost_"+temp[2]).val());
                varcost = varcost ? varcost/100 : 0;
                var vartot = varvol+varcost;
                
                var volume = parseInt($("#vol_"+temp[2]).val());
                var unitcost = parseFloat($("#cost_"+temp[2]).val());
                var tot = volume && unitcost ? 12*volume*unitcost : 0;
                if(temp[1]=="cost"){
                    $(this).text(tot.toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
                    sum[0] += tot;
                } else if(temp[1]=="year+1"){
                    var year1 = tot + tot * vartot / 100;
                    $(this).text(year1.toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
                    sum[1] += year1;
                } else if(temp[1]=="year+2"){
                    var year2 = tot + tot * 2 * vartot / 100;
                    $(this).text(year2.toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
                    sum[2] += year2;
                } else if(temp[1]=="year+3"){
                    var year3 = tot + tot * 3 * vartot / 100;
                    $(this).text(year3.toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
                    sum[3] += year3;
                }
            } else if (temp.length==2) {
                if(temp[1]=="cost"){ 
                    $(this).text(sum[0].toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
                } else if(temp[1] == "year+1"){
                    $(this).text(sum[1].toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
                } else if(temp[1] == "year+2"){
                    $(this).text(sum[2].toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
                } else if(temp[1] == "year+3"){
                    $(this).text(sum[3].toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
                }
                
               
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
        $("#opex_input input").each(function(){
            checkOpexInput(this);
        });
        $("#opex_input2 input").each(function(){
            checkOpexInput(this);
        });
        $("#opex_input textarea").each(function(){
            checkOpexInput(this);
        });
        calcTotOpex();
    }
}

setNewDeviseOpex("GBP");