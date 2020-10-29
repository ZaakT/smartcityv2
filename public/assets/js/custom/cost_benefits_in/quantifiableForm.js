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

function countSelectedQuantifiable(oForm) {
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
    $("#countQuantifiableSelect").text(n+" selected");
    //console.log(n);
    if (n >= 1) {
        $("#help_quantifiable").attr('hidden', 'hidden');
        return true;
    }
    else {
        $("#help_quantifiable").removeAttr('hidden');
        return false;
    }
}

function checkQuantifiableInput(){
    var ret = true;
    $("#quantifiable_input input").each(function(){
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
        } else if ( tab.includes("anVarVol") || tab.includes("volRed")){
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
    $("#quantifiable_input textarea").each(function(){
        if(tab.includes("guide")){

            $("#"+id).css("background","#C3E6CB");
    
        }
    });
    calcVolVarPerMonth();
    return ret;
}

function calcVolVarPerMonth(){
    $(".output").each(function(){
        var id = $(this).attr('id');
        if (id){
            var temp = id.split("_");
            if (temp.length==3){
                if(temp[1]=="varvol"){
                var val = parseFloat($("#anVarVol_"+temp[2]).val());
                var tot = val ? val/12/100 : 0;
                $(this).text(tot.toLocaleString(undefined,{style:"percent",maximumFractionDigits:2}));
                }
            }
        }
    });
}


try{
    countSelectedQuantifiable(form_quantifiable);
} catch {
    //do nothing
} finally {
    checkQuantifiableInput();
    calcVolVarPerMonth();
}