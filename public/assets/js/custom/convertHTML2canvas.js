

list_content =  [];
page2Imgs('.page-content');
function page2Imgs(where){
    $(where).each(function(){
        var id = $(this).attr('id');
        html2canvas($(this), {
            onrendered: function(canvas) {
                var imgData = canvas.toDataURL('image/png');
                //list_content[id] = imgData;
                console.log(imgData);
                list_content.push(imgData);
            },
        });
    })
}

$("#getPDF").click(function(){   
    getPDF(list_content);
});

function b64toBlob(b64Data, contentType, sliceSize) {
    contentType = contentType || '';
    sliceSize = sliceSize || 512;

    var byteCharacters = atob(b64Data);
    var byteArrays = [];

    for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        var slice = byteCharacters.slice(offset, offset + sliceSize);

        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }

        var byteArray = new Uint8Array(byteNumbers);

        byteArrays.push(byteArray);
    }

  var blob = new Blob(byteArrays, {type: contentType});
  return blob;
}

function getImages(tab){
    //if(Object.keys(tab).length > 0){
    if(tab.length > 0){
        for (const key in tab) {
            if (tab.hasOwnProperty(key)) {
                const base64image = tab[key];
                
                var block = base64image.split(";");
                // Get the content type
                var mimeType = block[0].split(":")[1];// In this case "image/png"
                // get the real base64 content of the file
                var realData = block[1].split(",")[1];// For example:  iVBORw0KGgouqw23....
            
                // Convert b64 to blob and store it into a variable (with real base64 as value)
                var canvasBlob = b64toBlob(realData, mimeType);
                window.saveAs(canvasBlob,key+".png");
            }
        }
    } else {
        console.log("There is no image !");
    }
    
}

function getPDF(tab){
    //if(Object.keys(tab).length > 0){
    if(tab.length > 0){
        var doc = new jsPDF();//'p', 'mm', [297, 210]); //210mm wide and 297mm high
        for (const key in tab) {
            if (tab.hasOwnProperty(key)) {
                const img = tab[key];
                doc.addImage(img, 'PNG', 10, 10);
                doc.addPage();
            }
        }
        doc.save('sample.pdf');
    } else {
        console.log("There is no image !");
    }
}
