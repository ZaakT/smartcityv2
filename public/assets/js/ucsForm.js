function countChecked_uc(oForm) {
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
    $("#countUCSelect").text(n+" selected");
    //console.log(n);
    if (n >= 4) {
        $("#help_uc").attr('hidden', 'hidden');
        return true;
    }
    else {
        $("#help_uc").removeAttr('hidden');
        return false;
    }
}

function toogleButton_uc(sel){
    var id='#more'+sel;
    var tab = $(id).classes();
    //console.log(tab);
    //console.log(tab);
    //console.log(tab.includes("mx-2"));
    if(tab.includes('active')){
        $(id).removeClass('active');
        $(id).addClass('disabled');
        //console.log("disable");
    } else {
        $(id).addClass('active');
        $(id).removeClass('disabled');
        //console.log("enable");
    }
    activeButton_uc(sel);
}

function activeButton_uc(sel){
    var tab = $("#more"+sel).classes();
    //console.log(tab);
    //var color = ['bg-danger','bg-primary','bg-success']
    if(!tab.includes('active') && tab.includes('disabled')){
        $("#more"+sel).removeClass('btn-dark');
        $("#more"+sel).addClass('btn-secondary');
        $(".more_"+sel).addClass('d-none');

    } else {
        $("#more"+sel).removeClass('btn-secondary');
        $("#more"+sel).addClass('btn-dark');
        $(".more_"+sel).removeClass('d-none');
    }
}

function colorLine(sum,nb,sel){
    const ref = nb*2;
    if(0<sum && sum<=ref*1/3){
        //console.log("not so pertinent");
        $(sel).css("background","orange");
    }
    else if(ref*1/3<sum && sum<=ref*2/3){
        //console.log("pertinent");
        $(sel).css("background","yellow");
    }
    else if(ref*2/3<sum && sum<=ref){
        //console.log("very pertinent");
        $(sel).css("background","yellowgreen");
    }
    else {
        //console.log("out of limit");
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

countChecked_uc(form_uc);
activeButton_uc('Crit');
activeButton_uc('DLT');


$("#table_uc td").each(function(){
    //console.log($(this).text());
    switch($(this).text()){
        case "0" :
            $(this).text("");
            //$(this).prepend('<img id="theImg" src="../../../public/img/open-iconic-master/png/people-2x.png"/>');
            $(this).prepend('<img width=30 height=30 id="circle_0" src="../../../public/img/circle_0.png"/>');
            //$(this).css("background","yellow");
            break;
        case "1" :
            $(this).text("");
            //$(this).prepend('<img id="theImg" src="../../../public/img/open-iconic-master/png/cog-2x.png"/>');
            $(this).prepend('<img width=30 height=30 id="circle_1" src="../../../public/img/circle_1.png"/>');
            //$(this).css("background", "orange");
            break;
        case "2" :
            $(this).text("");
            //$(this).prepend('<img id="theImg" src="../../../public/img/open-iconic-master/png/person-2x.png"/>');
            $(this).prepend('<img width=30 height=30 id="circle_2" src="../../../public/img/circle_2.png"/>');
            //$(this).css("background","green");
            break;
        default:
            break;
    }
});

$(".infos_pert").each(function(){
    //console.log($(this).text());
    var infos = $(this).text();
    infos = infos.split('-');
    //console.log(infos);
    var idUC = parseInt(infos[0]);
    var sum = parseInt(infos[1]);
    var nb = parseInt(infos[2]);
    colorLine(sum,nb,"#uc_"+String(idUC));
});