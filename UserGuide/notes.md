 Remarques sur le projet 

## Design 

### SideBar : 
Parfois elle va jusqu'en bas, parfois elle s'arrête plus tôt. Je pense qu'il pourrait être bien qu'elle suive l'écran. 

### Calendrier :
Par défaut, se mettre à la date du jour. 

Dans Schedule, lorque des dates sont choisies, il pourrait être bien de bloquer les dates qui ne peuvent plus être prises au lieu de seulement changer la couleur des dates en fonction de leur validité.

### Selections :
Il manque un bouton "tout selectionner" (il manque du coup aussi son frère : "tout désélectionner") sur toutes les selections avec de nombreux éléments (>10).

### GuideLine : 
Il manque la possibilité de pouvoir fermer la guideLine sans remonter en haut de la page. 

Sur la page Non Cash Benefits, elle est ouverte par défaut et on ne peut pasn la refermer. 

### Descriptions :
Ne faudrait-il pas laisser plus de place pour les descriptions ? 

### Bulles d'aide :
Les bulles d'aide prennent trop de place, surtout pour quelqu'un qui connait bien l'application, mettre plutôt une icone d'aide qui affiche la bulle plutôt que de la mettre tout le temps par défaut. 

### Table Use Case : 
La table faisant le résumé des Use Case n'est pas bien affichée sur certains écrans. 
Cette note est valable pour d'autres tables. 

### Info boutons 
Lors du survol des boutons, il pourrait être intéressant d'afficher quelques informations sup (précision des acronymes, spécification des actions accomplies par le bouton ...). 
Certains renvoient le nom du symbole qu'ils emploient, un message du type "suivant" serait peut-être plus intéressant. 

### Overal Score
Problème d'affichage de la table des scores à droite.  

Avec la fonction update, il pourrait être intéressant d'afficher combien il reste de poucentage à repartir pour retomber à 100% (peut-être ne pas mettre les cases en rouge mais plutot griser le bouton update et quand on le survol on voit de combien est l'écart à 100%).

Le bouton update est coupé. 

## Compréhension
### Rating
Le système d'echelle du rating n'est pas clair, on pourrait rendre cela en notant plus proprement l'echelle dans un tableau plutôt qu'avec seulement des sauts de lignes. 

### Schedule :
Manque d'explications. 

### Non Cash Benefits
Pourquoi limiter les probabiltés à des multiples de 10 ? Il faudrait le dire plus explicitement. 

## Bugs

### Working Capital Req.
La fleche ne fait aucune action.



http://smartcityv2/?A=cost_benefits&A2=capex&A3=capex_selected&projID=8&ucID=1 : pb dans la table capex

http://smartcityv2/?A=cost_benefits&A2=capex&projID=8&ucID=9 : create a capex



http://smartcityv2/?A=dashboards&A2=global_dashboard&projID=8 : 
pou certains projets, le dashbord bug (pour myProject par exemple)

dans le selection d'un projet, la valuer de "costs Benefits" peut changer sans raison.

où est passé la page size ??? : 
http://smartcityv2/?A=project_scoping&A2=size&projID=4