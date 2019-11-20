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

function checkImplemPeriod(){
    var val = $("#implem_period_input").val();
    val = val=="" ? 0 : parseInt(val);
    if(val <= 0){
        $("#implem_period_input").css("background","salmon");
        $("#implem_period_input").val("");
        return false;
    } else {
        $("#implem_period_input").val(val);
        $("#implem_period_input").css("background","palegreen");
        return true;
    }
}

function checkImplemInput(){
    var ret = true;
    $("#implem_input input").each(function(){
        var val = $(this).val();
        if($(this).classes().includes("volume")){
            val = val ? parseInt(val) : -1 ;
            //console.log(val);
            if(val <= 0){
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
            if(val <= 0.){
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
    calcTotImplem();
    return ret;
}

function calcTotImplem(){
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
    countSelectedImplem(form_implem);
} catch {
    //do nothing
} finally {
    checkImplemInput();
    checkImplemPeriod();
    calcTotImplem();
}