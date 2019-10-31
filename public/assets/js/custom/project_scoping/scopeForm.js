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


function countChecked_scope(formName) {
    var n = 0;
    var m = 0;   
    $("#"+formName+" input").each(function(){
        if(this.type.toLowerCase() =='checkbox' && this.checked==true){
            var tab = $(this).classes();
            if(tab.includes('meas')){
                n++;
                /*var measID = $(this).attr('id');
                console.log(measID);
                $(".meas_"+measID).attr("hidden","hidden");*/
            }
            else if(tab.includes('uc')){
                m++;
            }
        }
    });
    $("#countMeasSelect").text(n+" selected");
    //console.log(n);
    if (n > 0) {
        $("#help_meas").attr('hidden', 'hidden');
    }
    else {
        $("#help_meas").removeAttr('hidden');
    }
    $("#countUCSelect").text(m+" selected");
    //console.log(m);
    if (m > 0) {
        $("#help_uc").attr('hidden', 'hidden');
    }
    else {
        $("#help_uc").removeAttr('hidden');
    }
    return n>0&&m>0;
}

countChecked_scope("form_scope");