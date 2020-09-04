function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
      r: parseInt(result[1], 16),
      g: parseInt(result[2], 16),
      b: parseInt(result[3], 16)
    } : null;
}

function getColorsArray(ref){
    var list = [];
    var list2 = [];
    for (const i in ref) {
        if (ref.hasOwnProperty(i)) {
            //const proj_name = ref[i];
            var color_hex = getRandomColor();
            var color_rgb = hexToRgb(color_hex);
            list.push('rgb('+color_rgb['r']+','+color_rgb['g']+','+color_rgb['b']+','+0.2+')');
            list2.push('rgb('+color_rgb['r']+','+color_rgb['g']+','+color_rgb['b']+','+1+')');
        }
    }
    return [list,list2];
}


function toCapitalizeSentence(string){
    var tab = string.split(" ");
    var res = "";
    for (const word of tab) {
        res += word.charAt(0).toUpperCase() + word.slice(1) +" ";
    }
    return res;
}
