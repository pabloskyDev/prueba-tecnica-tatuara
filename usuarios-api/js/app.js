var url = 'usuarios.php';

(function() {
  consultar();
})();

function consultar(){
  EnviarPeticion('GET', '', 'Consultado');
}

function agregar(){
  var form = document.querySelector('#frm_registrar');
  var dataForm = new FormData(form);

  EnviarPeticion('POST', dataForm, 'Agregado');
}

function modificar(id, tipo){
  if(tipo == 1){
    url += '?id='+id;
    EnviarPeticion('GET', '', 'cargarModificar');

  }else if(tipo == 2){
    var form = document.querySelector('#frm_modificar');
    var formData = new FormData(form);

    /*documento = document.getElementById('docActualizar').value;
    nombre = document.getElementById('nomActualizar').value;
    apellidos = document.getElementById('apeActualizar').value;
    email = document.getElementById('emailActualizar').value;*/

    // url += '?id='+id+'&documento='+documento+'&nombre='+nombre+'&apellidos='+apellidos+'&email='+email;
    EnviarPeticion('PUT', formData, 'Modificado');
  }
  
}

function eliminar(id){
  console.log(id);

  url += '?id='+id;
  document.getElementById('btn_eliminar').addEventListener('click', function () {
    EnviarPeticion('DELETE', '', 'Eliminado');
    
  });

  
}

function EnviarPeticion(method, datos, decidir){
  var ajax = new XMLHttpRequest();

  ajax.onload = function(){
    var data = JSON.parse(this.responseText);
    DecidirAccion(data, decidir);
  };
  ajax.onerror = function(){
    console.log('Tenemos un error, ', error);
  };
  ajax.open(method, url, true);
  ajax.send(datos);

}

function DecidirAccion(data, decidir) {
  if(decidir == 'Consultado'){
    var tabla = `<tbody id="vistaTabla">`;
    var valorJson;

    for(var i in data){
      valorJson = data[i];

      tabla += `<tr>`;
        tabla += `<th scope="row">${valorJson.documento}</th>`;
        tabla += `<td>${valorJson.nombre}</td>`;
        tabla += `<td>${valorJson.apellidos}</td>`;
        tabla += `<td>${valorJson.email}</td>`;
        tabla += `<td><div class="btn-group">
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modificarUsuario" onclick="modificar(${valorJson.id},1);">Modificar</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarUsuario" onclick="eliminar(${valorJson.id});">Eliminar</button>
                      </div>
                  </td>`;
      tabla += `</tr>`;
    }

    tabla += `</tbody>`;
    document.querySelector('#vistaTabla').innerHTML = tabla;
  }
  if(decidir == 'Agregado'){
    // console.log('agregado con exito');
    document.getElementById("frm_registrar").reset();
    $("#agregarUsuario").modal('hide');
    CerrarPopup();
  }

  if(decidir == 'cargarModificar'){
    // console.log('Cargar datos modificar');
    url = 'usuarios.php';
    var frm_modificar = document.getElementById("frm_modificar").value;
    console.log(data);

    document.getElementById('id').value= `${data.id}`;
    document.getElementById('docActualizar').value= `${data.documento}`;
    document.getElementById('nomActualizar').value= `${data.nombre}`;
    document.getElementById('apeActualizar').value= `${data.apellidos}`;
    document.getElementById('emailActualizar').value= `${data.email}`;

    document.getElementById('btn_modificar').addEventListener('click', function () {
      modificar(data.id, 2);
    });
  }

  if(decidir == 'Modificado'){
    url = 'usuarios.php';
    console.log(data);

    $("#modificarUsuario").modal('hide');
    CerrarPopup();
  }

  if(decidir == 'Eliminado'){
    url = 'usuarios.php';
    console.log(data);

    $("#eliminarUsuario").modal('hide');
    CerrarPopup();
  }
}

function CerrarPopup() {
  $('body').removeClass('modal-open');
  $('.modal-backdrop').remove();

  consultar();
}