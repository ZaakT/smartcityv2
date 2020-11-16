function countProj(){
    var count = 0;
    $("input").each(function(){
        count+=this.checked;
    });
    return parseInt(count);
}

function checkCountProj(){
    var count = countProj();
    $("#countProjectelect").text(count+" selected");
    if(count<2){
        $('#help_project').removeAttr("hidden");
        return false;
    }else{
        $('#help_project').attr("hidden", true);
        return true;
    }

}
