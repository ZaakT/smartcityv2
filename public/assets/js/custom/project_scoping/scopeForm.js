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
        if(this.type.toLowerCase() =='checkbox'){
            var tab = $(this).classes();
            if(tab.includes('meas')){
                var measID = $(this).attr('id');
                if(this.checked==true){
                    n++;
                    console.log(measID);
                    $("."+measID).removeAttr("hidden");
                } else {
                    //console.log(measID);
                    $("."+measID).attr("hidden","hidden");
                    $("."+measID+" input").each(function(){
                        if(this.checked==true){
                            //console.log(this);
                            this.checked = false;
                        }
                    });
                }
            }
            else if(tab.includes('uc')){
                if(this.checked==true){
                    m++;
                    //console.log(m);
                }
            }
        }
    });

    $("#countMeasSelect").text(n+" selected");
    //console.log(n);
    if (n > 0) {
        $("#help_meas_scope").attr('hidden', 'hidden');
    }
    else {
        $("#help_meas_scope").removeAttr('hidden');
    }
    $("#countUCSelect").text(m+" selected");

    /*console.log(m);
    if (m > 0) {
        $("#help_uc").attr('hidden', 'hidden');
    }
    else {
        $("#help_uc").removeAttr('hidden');
    }*/
    
    if(n==0){
        $("#uc_table, #countUCSelect, #help_uc").attr("hidden","hidden");
    } else {
        $("#uc_table, #countUCSelect").removeAttr('hidden');
        if(m<=0){
            $("#help_uc").removeAttr('hidden');
        } else {
            $("#help_uc").attr('hidden', 'hidden');
        }
    }
    

    return n>0 && m>0;
}

countChecked_scope("form_scope");