
const color = ["#D9ADC4","#BFB6E3","#AEC8CD","#A1E3A6","#D9D5A5"]

function changeColorSelect(id){
    var val = $("#"+id).val();
    console.log("couleur : "+val);
    $("#"+id).css("background",color[val-1]);
}

function copy_sizes(id_prec,id_next) {
    //console.log(id_prec);
    //console.log(id_next);
    var selectedZones = [];
    $("#size_table tr").each(function(){
        if(this.id != "" > 0){
        //console.log(this.id);
        var tamp = this.id.split("_");
        //console.log(tamp[1]);
        selectedZones.push(tamp[1]);
        }
    });
    //console.log("selectedZones : "+selectedZones);
    for (var i in selectedZones) {
        //console.log(selectedZones[i]);
        //console.log("#sel_"+id_prec+"_"+selectedZones[i]);
        size = $("#sel_"+id_prec+"_"+selectedZones[i]).val();
        //console.log(size);
        $("#sel_"+id_next+"_"+selectedZones[i]).val(size);
        changeColorSelect("sel_"+id_next+"_"+selectedZones[i]);
    }
}
