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





function calcTotCapex(){
    var sum = 0;
    $("#tot_table_capex td").each(function(){
        var id = $(this).attr('id');
        if (id){
            var temp = id.split("_");
            if (temp.length==2){
                var val1 = parseInt($("#vol_"+temp[1]).val());
                var val2 = parseFloat($("#cost_"+temp[1]).val());
                var tot = val1 && val2 ? val1*val2 : 0;
                $(this).text(tot.toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
                sum += tot;
            } else if (temp.length==1) {
                $(this).text(sum.toLocaleString("en-UK",{style:"currency", currency:deviseName,maximumFractionDigits:3}));
            }
        }
    });
}

function setNewDeviseCapex(name){
    //console.log("setNewDeviseCapex")
    deviseName = name;
    try{
        countSelectedCapex(form_capex);
    } catch {
        //do nothing
    } finally {
        $("input").each(function(){
            checkCapexInput(this);
        });
        $("textarea").each(function(){
            checkCapexInput(this);
        });
        calcTotCapex();
    }
}

setNewDeviseCapex("GBP");
