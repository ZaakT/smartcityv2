
function fillByAv(id){
    $("#"+id+" input").each(function(){
        var element = $(this);
        /* console.log("-----");
        console.log(element.attr("placeholder"));
        console.log("-----"); */
        if(element.attr("placeholder")){
            var min = parseInt(element.attr("placeholder").split("-")[0]);
            var max = parseInt(element.attr("placeholder").split("-")[1]);
            //console.log(min,max);
            element.val(parseInt((min+max)/2));
            console.log(element.val());
            element.trigger("input");
        }
    });
}

function clearTable(id){
    $("#"+id+" input").each(function(){
        var element = $(this);
            element.val("");
            element.trigger("input");
    });
}


$('.myPopover').popover({
    trigger: 'focus'
  });
/* 
$('.myPopover').on('click', function (e) {
    $('.myPopover').not(this).popover('hide');
}); */