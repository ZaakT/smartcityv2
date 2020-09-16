function createDiv(idFather, idDiv){
    div = document.createElement('div');
    div.id  = idDiv;
    div.style = "font-weight: bold;";
    father = document.getElementById(idFather);
    father.appendChild(div);
    $("#"+idDiv).addClass("text-center alert alert-warning alert-dismissible fade show");
    div.setAttribute("role", "alert");
    return div;
}
function createButon(idFather){
    button = document.createElement('button');
    button.id = idFather+"_button";
    button.setAttribute("class", "close");
    button.setAttribute("data-dismiss", "alert");

    button.setAttribute("aria-label", "Close");
    button.setAttribute("type", "button");
    
    father = document.getElementById(idFather);
    father.appendChild(button);
    return button;
}

function createSpan(idFather){
    span = document.createElement('span');
    span.id = idFather+"_span";

    span.setAttribute("aria-hidden", "true");
    
    father = document.getElementById(idFather);
    father.appendChild(span);
    return button;
}
function addAlert(text, idDiv){
    idDiv = "alert_"+idDiv;
    newDiv = createDiv("alerts_container", idDiv);
    $("#"+idDiv).text(text);
    newButton = createButon(idDiv);
    newSpan = createSpan(idDiv+"_button");
    $("#"+idDiv+"_button_span").text(decodeURI("%C3%97"));
}


function clearAlerts(){
    var alerts = document.querySelectorAll('[id ^= "alert_"]');
    alerts.forEach(item => {
      item.remove();
    })
}
//addAlert("Some fields are missing.", "idDiv");