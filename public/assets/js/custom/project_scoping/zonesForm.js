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

/*
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

countChecked_zones("form_zones",true);*/

function countChecked_zones(formName){
    var nb_selectedZones = 0;
    $("#"+formName).each(function(){
        var j = 1;
        while($(".level_"+j).length!=0){
            var nb_hasChildren_checked = 0;
            var nb_checked = 0;
            $('.level_'+j).find('tr').each(function(){
                var tab = $(this).classes();
                var hasChildren = tab.includes("hasChildren");
                var input = $(this).find('input');
                var id_input = input.attr('id');
                if(id_input!=undefined){
                    if(input.prop('checked')){
                        nb_checked++;
                        $(".child_"+id_input).removeAttr("hidden");
                        if(hasChildren){
                            nb_hasChildren_checked++;
                            $('.level_'+(j+1)).removeAttr("hidden");
                        }
                    } else {
                        $(".child_"+id_input).find('input').prop("checked",false);
                        $(".child_"+id_input).attr("hidden","hidden");
                        if(nb_checked<=0){
                            $('.level_'+(j+1)).attr("hidden","hidden");
                        }
                    }
                }
            });
            j++;
            nb_selectedZones += nb_checked-nb_hasChildren_checked;
        }
    });
    console.log(nb_selectedZones);
    $("#countZonesSelect").text(nb_selectedZones+" selected")
    if (nb_selectedZones > 0) {
        $("#help_zones").attr('hidden', 'hidden');
        return true;
    }
    else {
        $("#help_zones").removeAttr('hidden');
        return false;
    }
}

countChecked_zones("form_zones");