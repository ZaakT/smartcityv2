function countChecked_meas(oForm) {
    var i, n = 0;
    var oElement;
    for (i = 0; i < oForm.elements.length; i++) {
        oElement = oForm.elements[i];
        // tagName permet de connaître le nom de l'élément
        // Je ne m'intéresse qu'aux <input> de type checkbox
        // Les .toLowerCase( ) me permettent d'être insensible à la casse
        if (oElement.tagName.toLowerCase() == "input") {
            if (oElement.type.toLowerCase() == "checkbox") {
                // La propriété checked est à true si la checkbox est cochée
                if (oElement.checked == true) {
                    n++;
                }
            }
        }
    }    
    $("#countMeasSelect").text(n+" selected");
    //console.log(n);
    if (n > 0) {
        $("#help_meas").attr('hidden', 'hidden');
        return true;
    }
    else {
        $("#help_meas").removeAttr('hidden');
        return false;
    }
}

countChecked_meas(form_meas);