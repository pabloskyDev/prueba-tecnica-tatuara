(function() {
  document.getElementById('btn_consultar').addEventListener('click', function (event) {
    event.preventDefault();
    // console.log("Hiciste click");
    consultar();
  });

  document.getElementById('btn_guardar').addEventListener('click', function (event) {
    event.preventDefault();
    agregar();
  });
})();

function consultar(){
  var ajax = new XMLHttpRequest();

  ajax.open('GET', 'usuarios.php', true);
  ajax.onload = function() {
    if(ajax.status == 200){
      document.querySelector('#respuesta').innerHTML = ajax.responseText;
    }else{
      document.querySelector('#respuesta').innerHTML = 'petición erronea';
    }
  }
  ajax.send();
}

function agregar(){
  var form = document.querySelector('form');
  var boton = document.querySelector('[type=submit]');
  boton.disabled = true;

  var fd = new FormData(form);
  var ajax = new XMLHttpRequest();

  ajax.open('POST', 'usuarios.php', true);
  ajax.onload = function() {
    boton.disabled = false;
    document.querySelector('#respuesta').innerHTML = ajax.responseText;
  }
  ajax.send(fd);
}

