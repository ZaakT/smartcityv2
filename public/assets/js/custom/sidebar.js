function colorActive(){
    $("input[type=radio]").first().prop("checked", true);
    var CheminComplet = document.location.href;
    var CheminRepertoire  = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( "/" ) );
    var NomDuFichier     = CheminComplet.substring(CheminComplet.lastIndexOf( "/" )+1 );
    var temp = NomDuFichier.split('=');
    var temp2 = [];
    
    for (let i = 0; i < temp.length; i++) {
        var element = temp[i].split("&");
        temp2.push(element);
    }
    if(temp2.length >= 3){
        active = "#"+ temp2[2][0];
        $(active).addClass("active");
    }
}

colorActive();

