
var tr_id = [];

$("#cball_table tr").each(function() {
    tr_id.push(this.id);
});




function getUcSelected(){
    //return -1 if we have to seletec all use cases else return the UC seleted.

    var selectEelemnt = document.getElementById("uc");
    try{

        var ucSeleted = selectEelemnt.options[selectEelemnt.selectedIndex].value;
        return ucSeleted;
    } catch(e){
        return 0;
    }
    
}




;
function updateData(){
    var data = $('#data').data("toShow");
    var uc = getUcSelected();
    var ucData = [];
    var deviseName = $('#deviseName').text();

    console.log(uc, data);
    for(let i =0; i< data.length; i++){       
        if(data[i][0]==uc){
            ucData = data[i].slice(1, data[i].length);
        }
    }
    
    for(let i = 0; i < ucData[0].length; i++){
        for(let j = 0; j < ucData.length; j++){
            $("#"+i+"_"+j).text(Math.round(ucData[j][i]).toLocaleString("en-UK",
            {
                style:"currency", 
                currency:deviseName,
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            }));
            
        }
    }

}

updateData();



function getLevel(id){

    return $("#"+id+"_level").text().split("\n")[0];
}
function findShowHide(id, showType=true){
    var level = getLevel(id).split('.');
    console.log(tr_id);
    tr_id.forEach(tr => {
        
        var levelTr = getLevel(tr).split('.');
        //console.log(tr);
        //console.log(levelTr, level);
        if(tr!=id){
            if(level[0]==levelTr[0] && (level[1]==0 || (level[1]==levelTr[1] && level[2]==0) )){
                if(showType){
                    show(tr);
                }else{
                    hide(tr);
                }
            }
        }
    });
}



function turnArrow(id){
    try{ 
        if( $("#"+id+"_left")[0].hasAttribute("hidden") ){
            $('#'+id+'_bottom').attr('hidden', true);
            $('#'+id+'_left').removeAttr('hidden');
        }else if( $("#"+id+"_bottom")[0].hasAttribute("hidden") ){
            $('#'+id+'_left').attr('hidden', true);
            $('#'+id+'_bottom').removeAttr('hidden');

        }

    }catch(error){}
}
function show(id){
    //console.log("I show :"+id);
    try{ 
        
            turnArrow(id);
            
        }catch(error){};
    $('#'+id).removeAttr('hidden');



}

function hide(id){
    //console.log("I hide :"+id);    if(test)
    try{ 
        if( !($('#'+id+'_bottom')[0].hasAttribute("hidden"))){
            turnArrow(id);
            $('#'+id).attr('hidden', true);
        }

    }catch(error){
        turnArrow(id);
        $('#'+id).attr('hidden', true);
    }

}

function show_hide_tab(id){
    if ( $("#"+id+"_left")[0].hasAttribute("hidden") ){
        turnArrow(id);
        findShowHide(id, false);
    } else {
        turnArrow(id);
        findShowHide(id, true);
    }

}






