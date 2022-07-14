var url = 'usuarios.php';

(function() {
  consultar();
})();

function consultar(){
  EnviarPeticion('GET', '', 'Consultado');
}

function agregar(){
  var form = document.querySelector('form');
  var dataForm = new FormData(form);

  EnviarPeticion('POST', dataForm, 'Agregado');
}

function modificar(id, tipo){
  if(tipo == 1){
    var formData = new FormData();
    formData.append("id", id);
    // var paramId = {id: id};
    // console.log(paramId);

    url += '?id='+id;
    EnviarPeticion('GET', '', 'cargarModificar');

  }else if(tipo == 2){
    console.log('Funcionó!!!');
    console.log(id);

    /*EnviarPeticion('PUT', formData, 'Modificado');*/

  }
  
}

function eliminar(id){
  console.log(id);

  url += '?id='+id;
  document.getElementById('btn_eliminar').addEventListener('click', function () {
    EnviarPeticion('DELETE', '', 'Eliminado');
    
  });

  
}

function EnviarPeticion(method, params, decidir){
  var ajax = new XMLHttpRequest();

  ajax.onload = function(){
    var data = JSON.parse(this.responseText);
    DecidirAccion(data, decidir);
  };
  ajax.onerror = function(){
    console.log('Tenemos un error, ', error);
  };
  ajax.open(method, url, true);
  ajax.send(params);

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
    console.log(data);
    console.log(data.documento);
    console.log(data.nombre);
    console.log(data.apellidos);
    console.log(data.email);

    // document.getElementById('documento').innerHTML(`...`);

    document.getElementById('btn_modificar').addEventListener('click', function () {
      modificar(data.id, 2);
    });
  }

  if(decidir == 'Modificado'){
    // console.log('Cargar datos modificar');
    // url = 'usuarios.php';
    // console.log(data);
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