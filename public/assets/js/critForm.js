function countChecked_crit(oForm) {
    var i, n = 0;
    var oElement;
    for (i = 0; i < oForm.elements.length; i++) {
        oElement = oForm.elements[i];
        // tagName permet de connaître le nom de l'élément
        // Je ne m'intéresse qu'aux <input> de type checkbox
        // Les .toLowerCase( ) me permettent d'être insensible à la casse
        if (oElement.tagName.toLowerCase() == "input") {
            if (oElement.type.toLowerCase() == "checkbox") {
                // La propriété checked est à true si la checkbox est cochée
                if (oElement.checked == true) {
                    n++;
                }
            }
        }
    }
    $("#countCritSelect").text(n+" selected");
    //console.log(n);
    if (n >= 5) {
        $("#help_crit").attr('hidden', 'hidden');
        return true;
    }
    else {
        $("#help_crit").removeAttr('hidden');
        return false;
    }
}

countChecked_crit(form_crit);

function toogleButton(cat){
    var id='#cat_'+String(cat);
    var tab = $(id).classes();
    //console.log(tab);
    //console.log(tab.includes("mx-2"));
    if(tab.includes('active')){
        $(id).removeClass('active');
        //console.log("disable");
    } else {
        $(id).addClass('active');
        //console.log("enable");
    }
    activeButton(id,cat);
}

function activeButton(sel,cat){
    var tab = $(sel).classes();
    //console.log(tab);
    var color = ['bg-danger','bg-primary','bg-success']
    console.log(cat);
    if(!tab.includes('active')){
        $(sel).removeClass(color[cat-1]);
        $(sel).addClass('btn-secondary');
        $(".critCat_"+cat).addClass('d-none');
        $(".critCat_"+cat).removeClass(color[cat-1]);

    } else {
        $(sel).removeClass('btn-secondary');
        $(sel).addClass(color[cat-1]);
        $(".critCat_"+cat).removeClass('d-none');
        $(".critCat_"+cat).addClass(color[cat-1]);
    }
}

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
