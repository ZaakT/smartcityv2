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
    var n = [0, 0, 0];  
    $("#"+formName+" input").each(function(){
        if(this.type.toLowerCase() =='checkbox'){
            var classes = $(this).classes();
            if(classes.includes('meas')){
                var measID = $(this).attr('id');
                if(this.checked==true){
                    n[0]++;
                    //console.log(measID);
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
            else if(classes.includes('cat')){
                var catID = $(this).attr('id');
                if(this.checked==true){
                    n[1]++;
                    $("."+catID).removeAttr("hidden");
                } else {
                    //console.log(catID);
                    $("."+catID).attr("hidden","hidden");
                    $("."+catID+" input").each(function(){
                        if(this.checked==true){
                            //console.log(this);
                            this.checked = false;
                        }
                    });
                }
            }
            else if(classes.includes('uc')){
                if(this.checked==true){
                    n[2]++;
                    //console.log(m);
                }
            }
        }
    });

    $("#countMeasSelectScope").text(n[0]+" selected");
    //console.log(n);
    if (n[0] > 0) {
        $("#help_meas_scope").attr('hidden', 'hidden');
    }
    else {
        $("#help_meas_scope").removeAttr('hidden');
    }
    $("#countCatSelectScope").text(n[1]+" selected");
    $("#countUCSelectScope").text(n[2]+" selected");

    /*console.log(m);
    if (m > 0) {
        $("#help_uc").attr('hidden', 'hidden');
    }
    else {
        $("#help_uc").removeAttr('hidden');
    }*/
    
    if(n[0]==0){
        $("#cat_table, #countCatSelectScope, #help_cat").attr("hidden","hidden");
    } else {
        $("#cat_table, #countCatSelectScope").removeAttr('hidden');
        if(n[2]<=0){
            $("#help_uc").removeAttr('hidden');
        } else {
            $("#help_uc").attr('hidden', 'hidden');
        }
    }

    if(n[1]==0){
        $("#uc_table, #countUCSelectScope, #help_uc").attr("hidden","hidden");
        $("#help_cat_scope").removeAttr('hidden');
    } else {
        $("#help_cat_scope").attr('hidden', 'hidden');
        $("#countUCSelectScope").removeAttr('hidden');
    }
    

    return n[0]>0 && n[2]>0;
}

countChecked_scope("form_scope");