//récupérer les infos json
var projectData = JSON.parse($('#bankability_data').html());
var currency = $('#currency').html().replace('(','').replace(')',' ');
var indicatorPositive = ['npv', 'roi'];
var finsoc = ['fin', 'soc'];
var indicatorNegative = ['payback', 'rr'];

function update_bankability(){
    
    //input['npv']['nogo'] = $('#npv_nogo').val();
    var input = {
        'npv':{
            'nogo':$('#npv_nogo').val(),
            'target':$('#npv_target').val()
        },
        'roi':{
            'nogo':$('#roi_nogo').val(),
            'target':$('#roi_target').val()
        },
        'payback':{
            'nogo':$('#payback_nogo').val(),
            'target':$('#payback_target').val()
        },
        'rr':{
            'nogo':$('#rr_nogo').val(),
            'target':$('#rr_target').val()
        },
        'nqbr':{
            'nogo':$('#nqbr_nogo').val(),
            'target':$('#nqbr_target').val()
        }
    };
    console.log(input);

    var score = {
        'fin_npv':0,
        'soc_npc':0,
        'fin_roi':0,
        'soc_roi':0,
        'fin_payback':0,
        'soc_payback':0,
        'rr':0,
        'nqbr':0
    };

    $('#display_target_npv').html(input.npv.target ? input.npv.target+' '+currency : " - "); 
    $('#display_target_roi').html(input.roi.target ? input.roi.target+' %' : " - ");
    $('#display_target_payback').html(input.payback.target ? input.payback.target+' months' : " - ");
    $('#display_target_rr').html(input.rr.target ? input.rr.target : " - ");
    $('#display_target_nqbr').html(input.nqbr.target ? input.nqbr.target : " - ");


    //NPV, ROI
    indicatorPositive.forEach(function(indic) {
        finsoc.forEach(function(type) {
            //console.log(projectData[type+'_'+indic], input[indic]['target']);
            if (projectData[type+'_'+indic] >= input[indic]['target']) {
                score[type+'_'+indic] = 1;
                $('#'+type+'_'+indic+'_thumb-down').attr('hidden', true);
                $('#'+type+'_'+indic+'_thumb-up').removeAttr('hidden');
                $('#'+type+'_'+indic+'_thumb-up').css("color", "green"); 
            } else if (input[indic]['nogo'] <= projectData[type+'_'+indic]) {
                score[type+'_'+indic] = 2;
                $('#'+type+'_'+indic+'_thumb-down').attr('hidden', true);
                $('#'+type+'_'+indic+'_thumb-up').removeAttr('hidden');
                $('#'+type+'_'+indic+'_thumb-up').css("color", "orange"); 
            } else {
                score[type+'_'+indic] = 3;
                $('#'+type+'_'+indic+'_thumb-up').attr('hidden', true);
                $('#'+type+'_'+indic+'_thumb-down').removeAttr('hidden');                
            }
        });

    });

    //payback
    finsoc.forEach(function(type) {
        if (projectData[type+'_payback'] <= input['payback']['target']) {
            score[type+'_payback'] = 1;
            $('#'+type+'_payback_thumb-down').attr('hidden', true);
            $('#'+type+'_payback_thumb-up').removeAttr('hidden');
            $('#'+type+'_payback_thumb-up').css("color", "green"); 
        } else if (input['payback']['nogo'] >= projectData[type+'_payback']) {
            score[type+'_payback'] = 2;
            $('#'+type+'_payback_thumb-down').attr('hidden', true);
            $('#'+type+'_payback_thumb-up').removeAttr('hidden');
            $('#'+type+'_payback_thumb-up').css("color", "orange"); 
        } else {
            score[type+'_payback'] = 3;
            $('#'+type+'_payback_thumb-up').attr('hidden', true);
            $('#'+type+'_payback_thumb-down').removeAttr('hidden');                
        }
    });

    //rating risk
    if (projectData['rating_risks'] <= input['rr']['target']) {
        score['rr'] = 1;
        $('.rr_thumb-down').attr('hidden', true);
        $('.rr_thumb-up').removeAttr('hidden');
        $('.rr_thumb-up').css("color", "green"); 
    } else if (input['rr']['nogo'] >= projectData['rating_risks']) {
        score['rr'] = 2;
        $('.rr_thumb-down').attr('hidden', true);
        $('.rr_thumb-up').removeAttr('hidden');
        $('.rr_thumb-up').css("color", "orange"); 
    } else {
        score['rr'] = 3;
        $('.rr_thumb-up').attr('hidden', true);
        $('.rr_thumb-down').removeAttr('hidden');                
    }

    //non quantifiable (= non cash) benefits rating
    if (projectData['rating_noncash'] >= input['nqbr']['target']) {
        score['nqbr'] = 1;
        $('.nqbr_thumb-down').attr('hidden', true);
        $('.nqbr_thumb-up').removeAttr('hidden');
        $('.nqbr_thumb-up').css("color", "green"); 
    } else if (input['rr']['nogo'] <= projectData['rating_noncash']) {
        score['nqbr'] = 2;
        $('.nqbr_thumb-down').attr('hidden', true);
        $('.nqbr_thumb-up').removeAttr('hidden');
        $('.nqbr_thumb-up').css("color", "orange"); 
    } else {
        score['nqbr'] = 3;
        $('.nqbr_thumb-up').attr('hidden', true);
        $('.nqbr_thumb-down').removeAttr('hidden');                
    }

}

//vérifier que target > nogo!! et no


//quand on clique sur le bouton ok
//récupérer les input
// si tous les input ne sont pas corrects: afficher "please rentrer tout"
// sinon

//pour le tableau score
//on initialise un tableau resultat
//on affiche les 5 target
//pour chaque indicateur
// si indicateur >= target => resultatscore = 1 et on cache pouce en en bas, on affiche pouce en haut et on le colorie en vert
// si no go <= indicateur < target => resultat =2, on cache pouce en bas, on affiche pouche en haut et on el colorie en orange
// si indicatuer < nogo => resultat = 3, on cache pouce en haut, on affiche pouce en bas


//pour les graph
// delta = target * 0,05
//pour chaque indicateur
// si indicateur < nogo - delta => resultat = 1
// si nogo-deltat <= indicateur < nogo+delta => resultat = 2
// ....


