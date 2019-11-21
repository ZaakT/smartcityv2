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

function countSelectedCapex(oForm) {
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
    $("#countCapexSelect").text(n+" selected");
    //console.log(n);
    if (n >= 1) {
        $("#help_capex").attr('hidden', 'hidden');
        return true;
    }
    else {
        $("#help_capex").removeAttr('hidden');
        return false;
    }
}

function checkCapexPeriod(){
    var val = $("#capex_period_input").val();
    val = val=="" ? 0 : parseInt(val);
    if(val <= 0){
        $("#capex_period_input").css("background","salmon");
        $("#capex_period_input").val("");
        return false;
    } else {
        $("#capex_period_input").val(val);
        $("#capex_period_input").css("background","palegreen");
        return true;
    }
}

function checkCapexInput(){
    var ret = true;
    $("#capex_input input").each(function(){
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
                $(this).css("background","palegreen");
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
                $(this).css("background","palegreen");
            }
        }
    });
    calcTotCapex();
    return ret;
}

function calcTotCapex(){
    var sum = 0;
    $("#tot_table td").each(function(){
        var id = $(this).attr('id');
        if (id){
            var temp = id.split("_");
            if (temp.length==2){
                var val1 = parseInt($("#vol_"+temp[1]).val());
                var val2 = parseFloat($("#cost_"+temp[1]).val());
                var tot = val1 && val2 ? val1*val2 : 0;
                $(this).text(tot.toLocaleString({maximumFractionDigits:3}));
                sum += tot;
            } else if (temp.length==1) {
                $(this).text(sum.toLocaleString({maximumFractionDigits:3}));
            }
        }
    });
}

try{
    countSelectedCapex(form_capex);
} catch {
    //do nothing
} finally {
    checkCapexInput();
    checkCapexPeriod();
    calcTotCapex();
}