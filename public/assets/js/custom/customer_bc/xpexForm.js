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

function checkXpexInput(id){
    var ret = true;
    id = id.getAttribute('id');
    console.log(id);
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
        } 
    } else if (tab.includes("unitCost") || tab.includes("period")){
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
    } else if(tab.includes("anVarCost") || tab.includes("anVarVol")){
        val = val ? parseFloat(val) : -1 ;

        console.log(val);
        if(val < 0 || val > 100){
            $("#"+id).css("background","salmon");
            $("#"+id).val("");
            ret = false;
        } else {
            //$("#"+id).val(val);
            $("#"+id).css("background","#C3E6CB");
        } 
    }

    calcTotXpex();
    return ret;
}

function calcTotXpex(){
    $("#xpex_table td").each(function(){
        var id = $(this).attr('id');
        if (id){
            var temp = id.split("_");
            if (temp[0]=="cost"){

                var val1 = parseInt($("#vol_"+temp[1]).val());
                var val2 = parseFloat($("#unitCost_"+temp[1]).val());
                var tot = val1 && val2 ? val1*val2 : 0;
                $(this).text(tot.toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
            } 
            
        }
    });
}

function setNewDeviseXpex(name){
    deviseName = name;
    try{
        countSelectedXpex(form_xpex);
    } catch {
        //do nothing
    } finally {
        $("input").each(function(){
            checkXpexInput(this);
        });
        calcTotXpex();
    }
}

setNewDeviseXpex("GBP");

scp -r ./ -P 1356 insightadm@ns3079645.ip-217-182-139.eu:~/smartcity_v2_test/smart_city_save 
