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

function countChecked_zones(formName,change=false) {
    change = false;
    $("#"+formName+" tbody tr").each(function(){
        var idTR = $(this).attr('id'); //"id_zone-id_parent"
        var IDs = idTR.split("_");
        var id_zone = parseInt(IDs[0]);
        var id_parent = parseInt(IDs[1]);
        $("#"+formName+" tbody input").each(function(){
            var id=$(this).attr('id');
            if(id==id_zone){
                if(this.checked==true){
                    $(".child_"+id_zone).removeAttr("hidden");
                    if(change){
                        $(".child_"+id_zone).find('input').each(function(){
                            this.checked=true;
                        });
                    }
                } else {
                    $(".child_"+id_zone).attr("hidden",'hidden');
                    $(".child_"+id_zone).find('input').each(function(){
                        this.checked=false;
                    });
                }
            }
        });
    });

}

countChecked_zones("form_zones",true);