var CheminComplet = document.location.href;
var CheminRepertoire  = CheminComplet.substring( 0 ,CheminComplet.lastIndexOf( "/" ) );
var NomDuFichier     = CheminComplet.substring(CheminComplet.lastIndexOf( "/" )+1 );

active = "#"+ NomDuFichier.substring(NomDuFichier.lastIndexOf("=")+1);

$(active).addClass("active");
