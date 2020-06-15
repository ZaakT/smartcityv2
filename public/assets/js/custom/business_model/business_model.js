//récupérer tous les json
var bm_infos = JSON.parse($('#bm_infos_json').html());
var bm_reco = JSON.parse($('#bm_reco_json').html());
var bm_reco_names = JSON.parse($('#bm_reco_names').html());
var bm_funding_options = JSON.parse($('#funding_options_json').html());
var level = ['Unlikely','Low','Moderate','High','Top'];

//INITIALISATION AVEC DONNES DE LA DB
var db_sel_bm = JSON.parse($('#db_sel_bm').html());
db_sel_bm['id_investcap'] ? $('#select_invest_cap').val(db_sel_bm['id_investcap']) : "" ;
db_sel_bm['id_payconst'] ? $('#select_payback_const').val(db_sel_bm['id_payconst']) : "" ;
db_sel_bm['id_bmpref'] ? $('#select_bm_pref').val(db_sel_bm['id_bmpref']) : "" ;

update_infos('invest_cap');
update_infos('payback_const');
update_infos('bm_pref');


//fonction update(item, value)

//  function update_infos(item,value)
//    va chercher la valeur correspondate et l'affiche dans le tableau 

function update_infos(item){
    //PROJECT CONTRAINTS
    var value = $('#select_'+item).val();
    var text = bm_infos[item][value]['description'];
    $('#'+item).html(text);

    update_reco_funding_options();
}

function update_reco_funding_options(){
    var invest_cap = $('#select_invest_cap').val();
    var payback_const = $('#select_payback_const').val();
    var bm_pref = $('#select_bm_pref').val();
    //récupérer unevariable uqi précise si c étoile ou jauge
    if (invest_cap && payback_const && bm_pref ){
        //BUSINESS MODEL RECOMMENDATIONS
        var reco = bm_reco[invest_cap][payback_const][bm_pref];
        $('#reco_bestfit').html(bm_reco_names[reco[1]]['name']);
        $('#reco_second').html(bm_reco_names[reco[2]]['name']);
        $('#reco_notreco').html(bm_reco_names[reco[3]]['name']);
        
        var funding_options = bm_funding_options[reco[1]][invest_cap];

        if ($('#funding_opt_table').hasClass('jauge')) {
                        //FUNDING OPTIONS JAUGE        
            for (item in funding_options) {
                $('#FO_'+item.replace(' ','')).html(level[funding_options[item]]);
                for (let i = 0; i <= funding_options[item] ; i++) {
                    $('#'+item.replace(' ','')+'_'+i).show();
                }
                for (let i = funding_options[item]+1; i < 5 ; i++) {
                    $('#'+item.replace(' ','')+'_'+i).hide();
                }

                // show les barres 1 à level et hide barre level+1 à 5
            }
        } else if ($('#funding_opt_table').hasClass('stars')) {
           //FUNDING OPTIONS ETOILES
            for (item in funding_options) { //colorer en bleu les étoiles de 0 à level et en gris les étoiles de level à 4
                for (let i = 0; i <= funding_options[item] ; i++) {
                    $('#'+item.replace(' ','')+'_'+i).addClass('text-primary');
                }
                for (let i = funding_options[item]+1; i < 5 ; i++) {
                    $('#'+item.replace(' ','')+'_'+i).removeClass('text-primary');
                }
            }
        }
    } 
}




