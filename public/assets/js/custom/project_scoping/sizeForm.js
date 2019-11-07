
const color = ["#D9ADC4","#BFB6E3","#AEC8CD","#A1E3A6","#D9D5A5"]

function changeColorSelect(id){
    var val = $("#"+id).val();
    console.log(val);
    $("#"+id).css("background",color[val-1]);
}