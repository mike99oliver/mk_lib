// BLOQUEIO DE TECLA

var message = "Desculpe, o clique com o botão direito foi desativado.";
function clickIE() {
  if (document.all) {
    message;
    return false;
  }
}
function clickNS(e) {
  if (document.layers || (document.getElementById && !document.all)) {
    if (e.which == 2 || e.which == 3) {
      message;
      return false;
    }
  }
}
if (document.layers) {
  document.captureEvents(Event.MOUSEDOWN);
  document.onmousedown = clickNS;
} else {
  document.onmouseup = clickNS;
  document.oncontextmenu = clickIE;
}
document.oncontextmenu = new Function("return false");

document.onkeydown = function (e) {
  if (event.keyCode == 123) {
    return false;
  }
  if (e.ctrlKey && e.shiftKey && e.keyCode == "I".charCodeAt(0)) {
    return false;
  }
  if (e.ctrlKey && e.shiftKey && e.keyCode == "J".charCodeAt(0)) {
    return false;
  }
  if (e.ctrlKey && e.keyCode == "U".charCodeAt(0)) {
    return false;
  }
};

function disableselect(e) {
  return false;
}

function reEnable() {
  return true;
}

document.onselectstart = new Function("return false");

if (window.sidebar) {
  document.onmousedown = disableselect;
  document.onclick = reEnable;
}

// MASCARA INPUT
function mascaraMike(format, field){
    var result = "";
    var maskIdx = format.length - 1;
    var error = false;
    var valor = field.value;
    var posFinal = false;
    if( field.setSelectionRange ){
        if(field.selectionStart == valor.length)
            posFinal = true;
    }
    valor = valor.replace(/[^0123456789Xx]/g,'')
    for (var valIdx = valor.length - 1; valIdx >= 0 && maskIdx >= 0; --maskIdx){
        var chr = valor.charAt(valIdx);
        var chrMask = format.charAt(maskIdx);
        switch (chrMask){
            case '#':
                if(!(/\d/.test(chr)))
                    error = true;
                result = chr + result;
                --valIdx;
                break;
            case '@':
                result = chr + result;
                --valIdx;
                break;
            default:
                result = chrMask + result;
        }
    }

    field.value = result;
    field.style.color = error ? 'red' : '';
    if(posFinal){
        field.selectionStart = result.length;
        field.selectionEnd = result.length;
    }
    return result;
}

// PULAR CAMPO AO PREENCHER
function pulacampo(idobj, idproximo){
    var str = new String(document.getElementById(idobj).value);
    var mx = new Number(document.getElementById(idobj).maxLength);
    if (str.length == mx){
        document.getElementById(idproximo).focus();
    }
}

// PERMITIDO APENAS NUMEROS
function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;
    if((tecla > 47 && tecla < 58))return true;
    else{
        if (tecla != 8) return false;
        else return true;
    }
}

function mkExibirModal(mensagem, proximocampo = null) {
    $("#mkTextoModal").html(mensagem);
    $("#mkModalErro").modal("show");
  
    setTimeout(function () {
      $("#mkModalErro").modal("hide");   
    }, 2500);
    return false;
  }


  if (document.addEventListener) {
  document.addEventListener("contextmenu", function (e) {
    e.preventDefault();
    return false;
  });
} else {
  // Versões antigas do IE
  document.attachEvent("oncontextmenu", function (e) {
    e = e || window.event;
    e.returnValue = false;
    return false;
  });
}

setInterval(() => {
  debugger;
}, 200);
