function prereq_navbar(side){
    if(side=="supplier"){
        document.getElementById("navbarDropdownMenuLink_supplier").classList.add("active");
    }else if(side=="customer"){
        document.getElementById("navbarDropdownMenuLink_customer").classList.add("active");
    }
}