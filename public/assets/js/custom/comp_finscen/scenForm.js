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
                var id = $(this).attr('id');
                var temp = id.split('proj_');
                var projID = parseInt(temp[1]);
                if(this.checked==true){
                    n++;
                    console.log("#"+formName+" .proj_"+projID);
                    console.log($("#"+formName+" .proj_"+projID));
                    $("#"+formName+" .proj_"+projID).removeAttr("hidden");
                } else {
                    $("#"+formName+" .proj_"+projID).attr("hidden","hidden");
                    $("#"+formName+" .proj_"+projID+" input").each(function(){
                        if(this.checked==true){
                            this.checked = false;
                            countChecked_selScen("form_proj");
                        }
                    });
                }
            }
        }
    });

    $("#countProjSelect").text(n+" selected");
    //console.log(n);
    if (n >= 1) {
        $("#help_proj").attr('hidden', 'hidden');
    }
    else {
        $("#help_proj").removeAttr('hidden');
    }
    
    return n >= 1;
}

function countChecked_selScen(formName) {
    var n = 0;   
    $("#"+formName+" input").each(function(){
        if(this.type.toLowerCase() =='checkbox'){
            var tab = $(this).classes();
            if(tab.includes('scen')){
                var scenID = $(this).attr('id');
                if(this.checked==true){
                    n++;
                }
            }
        }
    });

    $("#countScenSelect").text(n+" selected");
    //console.log(n);
    if (n >= 2) {
        $("#help_scen").attr('hidden', 'hidden');
    }
    else {
        $("#help_scen").removeAttr('hidden');
    }
    
    return n >= 2;
}

countChecked_selProj("form_proj");
countChecked_selScen("form_proj");