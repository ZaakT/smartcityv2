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


function countChecked_selProj(formName) {
    var n = 0;   
    $("#"+formName+" input").each(function(){
        if(this.type.toLowerCase() =='checkbox'){
            var tab = $(this).classes();
            if(tab.includes('proj')){
                var projID = $(this).attr('id');
                if(this.checked==true){
                    n++;
                    $("."+projID).removeAttr("hidden");
                } else {
                    //console.log(projID);
                    $("."+projID).attr("hidden","hidden");
                    $("."+projID+" input").each(function(){
                        if(this.checked==true){
                            //console.log(this);
                            this.checked = false;
                        }
                    });
                }
            }
        }
    });

    $("#countProjSelect").text(n+" selected");
    //console.log(n);
    if (n >= 2) {
        $("#help_proj").attr('hidden', 'hidden');
    }
    else {
        $("#help_proj").removeAttr('hidden');
    }
    

    return n >= 2;
}

countChecked_selProj("form_proj");