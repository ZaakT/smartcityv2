var input = document.getElementById("logoName")//document.getElementById("#logoName");
console.log(input);
input.addEventListener('change', updateImage);

function updateImage(){
    console.log("we change");
    var curFiles = input.files;
    if(curFiles.length != 0){
        var image = document.getElementById("imageLogo");
        image.src = window.URL.createObjectURL(curFiles[0]);

    }
}
function uploadImage(){
    console.log($("#logoName").val());

}
