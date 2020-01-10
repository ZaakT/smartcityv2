function getPart(idDev){
    var CheminComplet = document.location.href;
    var CheminRepertoire  = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( "/" ) );
    var NomDuFichier     = CheminComplet.substring(CheminComplet.lastIndexOf( "/" )+1 );
    var temp = NomDuFichier.split('=');
    var temp2 = [];
    var temp3 = [];
    var temp4 = ""

    for (let i = 0; i < temp.length; i++) {
        var element = temp[i].split("&");
        temp2.push(element);
    }

    for (let i = 0; i < temp2.length; i++) {
        var element = temp2[i];
        if (i ==0){
            temp4 += element;
        } else if (element.length > 0 && i > 0){
            for (let j = 0; j < element.length; j++) {
                var element2 = element[j];
                temp3.push(element2);
                temp4 += ","+element2;
            }
        }
    }

    console.log(temp3);
    console.log(temp4);
    var href = $("#link_setDevise_"+idDev).attr('href');
    $("#link_setDevise_"+idDev).attr('href',href+"&lastURL="+temp4+"");
    //console.log($("#link_setDevise_"+idDev).attr('href'));
    return NomDuFichier;
}