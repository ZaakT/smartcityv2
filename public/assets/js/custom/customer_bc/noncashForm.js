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

function countSelectedNonCash(oForm) {
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
    $("#countNonCashSelect").text(n+" selected");
    //console.log(n);
    if (n >= 1) {
        $("#help_noncash").attr('hidden', 'hidden');
        return true;
    }
    else {
        $("#help_noncash").removeAttr('hidden');
        return false;
    }
}

function checkNonCashInput(){
    var ret = true;
    $("#noncash_input input").each(function(){
        var val = $(this).val();
        var tab = $(this).classes()
        if(tab.includes("impact")){
            val = val ? parseInt(val) : -1 ;
            //console.log(val);
            if(val <= 0){
                $(this).css("background","salmon");
                $(this).val("");
                ret = false;
            } else if(val > 10) {
                $(this).css("background","salmon");
                ret = false;
            } else {
                $(this).val(val);
                $(this).css("background","#C3E6CB");
            }
        } else if (tab.includes("prob")){
            val = val ? parseFloat(val) : -1 ;
            var temp = String(val).split(".");
            if(val < 0.){
                $(this).css("background","salmon");
                $(this).val("");
                ret = false;
            } else if (temp.length==2 && temp[1].length>3){
                $(this).css("background","salmon");
                ret = false;
            } else if(val > 100) {
                $(this).css("background","salmon");
                ret = false;
            } else {
                //$(this).val(val);
                $(this).css("background","#C3E6CB");
            }
        }
    });
    calcTotNonCash();
    return ret;
}

function calcTotNonCash(){
    var sum = 0;
    var nb = 0;
    $("#tot_table_noncash td").each(function(){
        var id = $(this).attr('id');
        if (id){
            var temp = id.split("_");
            if (temp.length==2){
                if(temp[0]=="weighted"){
                    var impact = parseInt($("#impact_"+temp[1]).val());
                    var prob = parseFloat($("#prob_"+temp[1]).val());
                    var weighted = impact && prob ? impact*prob/100 : 0;
                    $(this).text(weighted.toLocaleString(undefined,{minimumFractionDigits:1,maximumFractionDigits:1}));
                    sum += weighted;
                    nb++;
                }
            } else if (temp.length==1) {
                if(temp[0]=="tot"){
                    $(this).text((sum/nb).toLocaleString(undefined,{minimumFractionDigits:1,maximumFractionDigits:1}));
                }
            }
        }
    });
}

try{
    countSelectedNonCash(form_noncash);
} catch {
    //do nothing
} finally {
    checkNonCashInput();
    calcTotNonCash();
}