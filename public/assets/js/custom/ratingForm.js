
function colorFilledRating(){
    //console.log("--------------------");
    $("#table_rate input").each(function(){
        console.log(this);
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

colorFilledRating();
