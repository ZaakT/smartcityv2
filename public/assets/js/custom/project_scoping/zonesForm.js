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
        while($(".level_"+j).length!=0){ //tant qu'il y a des niveaux
            var nb_hasChildren_checked = 0;
            var nb_checked = 0;
            $('.level_'+j).find('tr').each(function(){ //pour toutes les lignes des tableaux
                var classes = $(this).classes();
                //console.log(classes);
                var hasChildren = classes.includes("hasChildren");
                //console.log(hasChildren);
                var input = $(this).find('input');
                var id_input = input.attr('id');
                //console.log(id_input);
                if(id_input!=undefined){
                    if(input.prop('checked')){ //si la case de cette ligne est checkée, càd si la zone est sélectionnées
                        nb_checked++; 
                        $(".child_"+id_input).removeAttr("hidden"); //on affiche les zones enfants de cette zone
                        if(hasChildren){ //si la zone a des enfants
                            nb_hasChildren_checked++; 
                            $('.level_'+(j+1)).removeAttr("hidden"); //on affiche les tableaux de niveau supérieurs
                        }
                    } else {//sinon si pas d'enfants
                        $(".child_"+id_input).find('input').prop("checked",false); //les enfants de cette zone sont déselectionnés
                        $(".child_"+id_input).attr("hidden","hidden"); //on cache les enfants de cette zone
                        if(nb_checked<=0){ // si le nombre de zones selctionnées == 0
                            $('.level_'+(j+1)).attr("hidden","hidden"); //on efface les tableaux enfants
                        }
                    }
                }
            });
            j++;
            nb_selectedZones += nb_checked-nb_hasChildren_checked;
        }
    });
    //console.log(nb_selectedZones);
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