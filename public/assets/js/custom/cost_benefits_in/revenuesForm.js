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

function submitForm(formName){/*
    var ret = true;
    $("#revenues_input input").each(function(){
        if(!checkRevenuesInput(this)){
            ret = false;
        }
    });
    if(ret){
        console.log("we submit");
        //$("#"+formName).submit();
    }*/
}

function countSelectedRevenues(oForm) {
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
    $("#countRevenuesSelect").text(n+" selected");
    //console.log(n);
    if (n >= 1) {
        $("#help_revenues").attr('hidden', 'hidden');
        return true;
    }
    else {
        $("#help_revenues").removeAttr('hidden');
        return false;
    }
}

function checkRevenuesInput(id){
    clearAlerts();
    var revenue_start = $("#pricing_start").text();
    var uc_end = $("#uc_end").text();
    var idAlert = 0;


    var ret = true;
    id = id.getAttribute('id');
    //console.log(id);
    var val = $("#"+id).val();
    //console.log(val);
    var tab = $("#"+id).classes();
    console.log(val, tab);
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
            });
        }
    } else if (tab.includes("unit_cost")){
        //console.log(val);
        val = val ? parseFloat(val) : -1 ;
        //console.log(val);
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
            //$(this).val(val.toLocaleString(undefined));
        }
    }  else if (tab.includes("unitIndic") || tab.includes("unit_rev") || tab.includes("anVarVol") || tab.includes("anVarRev")){
        //console.log(val);
        if(val){
            val = parseFloat(val);
            var temp = String(val).split(".");
            if (temp.length==2 && temp[1].length>3){
                $("#"+id).css("background","salmon");
                ret = false;
            } else {
                //$(this).val(val);
                $("#"+id).css("background","#C3E6CB");
                //$(this).val(val.toLocaleString(undefined));
            }
        } else {
            $("#"+id).css("background","salmon");
            ret = false;
        }
    }  else if (tab.includes("ratio")){
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
            });
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
                $("#"+id).css("background","#C3E6CB");
            }
        }else{
            $("#"+id).css("background","#C3E6CB");
        }

    }
    calcTotRevenues();
    return ret;
}

/*
function calcTotRevenues(){
    var sum = 0;
    $("#tot_table_rev td").each(function(){
        var id = $(this).attr('id');
        if (id){
            var temp = id.split("_");
            if (temp.length==3){
                if(temp[1]=="rev"){
                    var val1 = parseInt($("#vol_"+temp[2]).val());
                    var val2 = parseFloat($("#rev_"+temp[2]).val());
                    var tot = val1 && val2 ? 12*val1*val2 : 0;
                    $(this).text(tot.toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
                    sum += tot;
                } else if(temp[1]=="varvol"){
                    var val = parseFloat($("#anVarVol_"+temp[2]).val());
                    var tot = val ? val/100 : 0;
                    $(this).text(tot.toLocaleString(undefined,{style:"percent",maximumFractionDigits:3}));
                } else if(temp[1]=="varrev"){
                    var val = parseFloat($("#anVarRev_"+temp[2]).val());
                    var tot = val ? val/100 : 0;
                    $(this).text(tot.toLocaleString(undefined,{style:"percent",maximumFractionDigits:3}));
                } else if(temp[1]=="combvar"){
                    var varvol = parseFloat($("#anVarVol_"+temp[2]).val());
                    varvol = varvol ? varvol/100 : 0;
                    var varrev = parseFloat($("#anVarRev_"+temp[2]).val());
                    varrev = varrev ? varrev/100 : 0;

                    var tot = varvol && varrev ? varvol+varrev : 0;
                    $(this).text(tot.toLocaleString(undefined,{style:"percent",maximumFractionDigits:3}));
                }
            } else if (temp.length==2) {
                $(this).text(sum.toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
            }
        }
    });
}
*/

function calcTotRevenues(){
    var sum = [0, 0, 0 ,0];
    $("#tot_table_rev td").each(function(){
        var id = $(this).attr('id');
        if (id){
            var temp = id.split("_");
            if (temp.length==3){
                var varvol = parseFloat($("#anVarVol_"+temp[2]).val());
                varvol = varvol ? varvol/100 : 0;
                var varrev = parseFloat($("#anVarRev_"+temp[2]).val());
                varrev = varrev ? varrev/100 : 0;
                var vartot = varvol+varrev;

                var volume = parseInt($("#vol_"+temp[2]).val());
                var unitcost = parseFloat($("#rev_"+temp[2]).val());
                var tot = volume && unitcost ? 12*volume*unitcost : 0;

                if(temp[1]=="rev"){
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
                if(temp[1]=="rev"){ 
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


function setNewDeviseRevenues(name){
    deviseName = name;
    try{
        countSelectedRevenues(form_revenues);
    } catch {
        //do nothing
    } finally {
        $("#revenues_input input").each(function(){
            checkRevenuesInput(this);
        });
        calcTotRevenues();
    }
}

setNewDeviseRevenues("GBP");
