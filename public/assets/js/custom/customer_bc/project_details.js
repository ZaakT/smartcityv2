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
    
    console.log(uc, data);
    for(let i =0; i< data.length; i++){       
        if(data[i][0]==uc){
            ucData = data[i].slice(1, data[i].length);
        }
    }
    
    for(let i = 0; i < ucData[0].length; i++){
        for(let j = 0; j < ucData.length; j++){
            $("#"+i+"_"+j).text(ucData[j][i]);
            
        }
    }

}

updateData();