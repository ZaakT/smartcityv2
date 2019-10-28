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

function colorFilled(){
    //console.log("--------------------");
    $("#table_rate input").each(function(){
        //console.log(this);
        var element = $(this);
        var value = element.val();
        value = value=="" ? 0 : parseInt(value);
        //console.log(value);
        if(value<1 || value>10){
            element.css("background","salmon");
        } else {
            element.css("background","palegreen");
        }
    });
}

colorFilled();
