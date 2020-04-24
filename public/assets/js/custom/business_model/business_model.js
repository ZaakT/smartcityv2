//récupérer tous les json
var bm_infos = JSON.parse($('#bm_infos_json').html());
console.log(bm_infos);


//fonction update(item, value)

//  function update_infos(item,value)
//    va chercher la valeur correspondate et l'affiche dans le tableau et dans investment capacity qualif si item = invest cap

function update_infos(item, value){
    console.log('ok');
    var text = bm_infos[item][value]['description'];
    $('#'+item).html(text);
}

//  function updaye_bm_reco()
//     récupère les valeurs des trois items input
//     va cherche les trois valeurs résultat de la combinaison dans matrix bm 1
//     les affiche

//  function update_funding_options()
//     récupère les valeurs des trois items input
//     va cherche les huit valeurs résultat de la combinaison dans matrix bm 2
//     les affiche
