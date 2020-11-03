function getMaxID(type){
    maxID = -1
    $("."+type).each(function() {
        id = parseInt(this.id.split("_")[1])
        maxID = id>maxID ? id : maxID
    });
    //console.log(maxID);
    return parseInt(maxID)
}

function getNbItems(type){
    return $("."+type).length;
}


function createInput(type, father){

    //We create the 1st div
    newID = getMaxID(type)+1
    var divCont = document.createElement("div");
    divCont.classList.add("input-group");
    divCont.classList.add("mb-3");
    divCont.id = "div_"+type+'_'+newID
    father.appendChild(divCont)

    //We create the input
    var newInput = document.createElement("input");
    newInput.classList.add("form-control");
    newInput.classList.add(type);
    newInput.type = "text";
    newInput.id = type+"_"+newID;
    newInput.name = type+"_"+newID;
    divCont.appendChild(newInput)

    //We create the 2nd div
    var divModal = document.createElement("div");
    divModal.classList.add("input-group-append");
    divCont.appendChild(divModal);

    //We create the add span
    var spanAdd = document.createElement("span");
    spanAdd.classList.add("input-group-text");
    spanAdd.classList.add("oi");
    spanAdd.classList.add("oi-plus");
    spanAdd.id = "create_"+type+'_'+newID;
    spanAdd.setAttribute('onclick',"addInput('"+type+"')");
    divModal.appendChild(spanAdd);

    //We create the delete span
    var spanAdd = document.createElement("span");
    spanAdd.classList.add("input-group-text");
    spanAdd.classList.add("oi");
    spanAdd.classList.add("oi-trash");
    spanAdd.id = "delete_"+type+'_'+newID;
    spanAdd.setAttribute('onclick',"deleteInput('"+type+"', '"+newID+"')");
    divModal.appendChild(spanAdd);





}

function addInput(type){
    console.log("add " + type)
    father = document.getElementById(type+"_container")
    createInput(type, father)

}

function deleteInput(type, idComplement){
    console.log("delete " + type +" "+idComplement)
    document.getElementById("div_"+type+"_"+idComplement).outerHTML = "";
    if(getNbItems(type)==0){
        addInput(type)
    }

}