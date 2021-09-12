//INICIALIZACIÓN DE VARIABLES
let contador = 0;
let contadorP = 0;

var codInput = document.getElementById('codInput'),
  list = document.getElementById('list'),
  valor = document.getElementById('contPcod'),
  conf = document.getElementById('conf'),
  pieza = document.getElementById('contPieza'),
  listRegalo = document.getElementById('listRegalo'),
  guardarLista = document.getElementById('guardarLista'),
  valregalo = document.getElementById('contRegalo');
var arrayPedido = [];
var arrayRegaloLista = [];


var addcod = function () {

  //RESCATAMOS EL VALOR DEL INPUT
  var codigo = codInput.value;
  //VALIDACIÓN DEL INPUT

  if (codigo != "") {

    // SE ENVIAN LOS DATOS A arriboCS
    controlador = [];
    controlador.push("find");

    controlador.push(codigo);
    $.ajax({
      type: 'POST',
      url: 'recursos/funciones/arribo_fx.php',
      data: { controlador },
      datatype: { JSON },
      //SE RECIBE LA RESPUESTA EN JSON

      success: function (succesrespuesta) {
        let resp = JSON.parse(succesrespuesta);
        var arrayRegalo = [];

        if (resp['existe']) {

          if (arrayPedido.length <= 0) {
            arrayPedido.push([]);
            arrayPedido[0][0] = codigo;
            arrayPedido[0][1] = resp['direccion'];
            arrayPedido[0][2] = 1;
            for (let index = 1; index <= resp['regalo']['cantidad']; index++) {
              console.log("hola " + index);
              arrayRegalo.push([resp['regalo']['nombre_regalo'][index], resp['regalo']['cantidad_regalo'][index]]);
              regaloLista(resp['regalo']['nombre_regalo'][index], resp['regalo']['cantidad_regalo'][index]);
            }
            arrayPedido[0][3] = arrayRegalo;

            console.log(arrayPedido[0]);
            ActualizarLista(arrayPedido[0]);
          } else {
            //ENTRA SI LA LISTA DEL HTML YA TIENE ITEMS
            //BUSCAMOS EL  CODIGO INGRESADO EN EL ARRAY
            codLista = buscarEnArray(arrayPedido, codigo);
            if (codLista > -1) {
              console.log("COMPROBACIÓN DE PIEZAS");
              console.log(arrayPedido);

              //ENTRA SI ENCUETRA EL CODIGO EN LA LISTA
              //SE COMRUEBA LA CANTIDAD DE PIEZAS DEL CODIGO (SE INGRESA EL CODIGO x  LA CANTIDAD DE PIEZAS)
              if (resp['piezas'] < (arrayPedido[codLista][2] + 1)) {
                //SI EL CODIGO YA TIENE TODAS LAS PIEZAS SE ENVIA LA ALERTA
                alert("El codigo fue ingresado en su totalidad");
              } else {
                //SI LE FALTAN PIEZAS, SE SUMA 1 AL ARRAY Y SE ACTUALIZA EN EL HTML(SE REPITE HASTA QUE ESTÉN TODAS LAS PIEZAS DE ESE CODIGO)
                arrayPedido[codLista][2]++;
                contadorP++;
                pieza.textContent = contadorP;
              }
            } else {

              console.log("ES UN CODIGO NUEVO");

              //ENTRA SI NO ENCUETRA EL CODIGO EN LA LISTA Y SI NO ES EL PRIMERO DE LA LISTA
              //AGREGAMOS EL NUEVO CODIGO AL ARRAY

              for (let index = 1; index <= resp['regalo']['cantidad']; index++) {
                console.log("llamada " + index);
                arrayRegalo.push([resp['regalo']['nombre_regalo'][index], resp['regalo']['cantidad_regalo'][index]]);
                regaloLista(resp['regalo']['nombre_regalo'][index], resp['regalo']['cantidad_regalo'][index]);
              }

              arrayPedido.push([codigo, resp['direccion'], 1, arrayRegalo]);
              //SE ACTUALIZA LA LISTA
              //console.log(arrayPedido);

              ActualizarLista(arrayPedido[arrayPedido.length - 1]);
            }
          }




        } else {

          alert("Codigo erróneo o no registrado");
        }
      }
    });
  } else {
    //SI NO HAY NADA EN EL INPUT SE CAMBIA EL PLACEHOLDER DEL MISMO
    codInput.setAttribute("placeholder", "Ingrese un código");
  }
}




function ActualizarLista(pedido) {

  // SE CREA EL ELEMENTO LI
  conjunto = document.createElement("tr");
  // SE PASA EL CODIGO A NODO DE TEXTO
  codigoTabla = document.createElement("td");
  codigoTabla.setAttribute("class", "text-left");
  direccionTabla = document.createElement("td");
  direccionTabla.setAttribute("class", "text-left");

  delet = document.createElement("td");
  delet.setAttribute("class", "text-right");
  btn = document.createElement("button");
  btn.appendChild(document.createTextNode("ELIMINAR"));
  btn.setAttribute("class", "btn btn-danger");


  codigoTabla.appendChild(document.createTextNode(pedido[0]));
  direccionTabla.appendChild(document.createTextNode(pedido[1]));
  btn.setAttribute("onclick", "eliminarProducto(this.id)");
  btn.setAttribute("id", pedido[0])

  delet.appendChild(btn);

  //SE INGRESA EL NODO AL LI RECIEN CREADO
  conjunto.appendChild(codigoTabla);
  conjunto.appendChild(direccionTabla);
  conjunto.appendChild(delet);
  conjunto.setAttribute("id", pedido[0])

  cargarListaRegalo();
  // buscarRegalo(pedido);
  //SE INGRESA EL LI CON EL NODO A LA LISTA "list" DEL HTML
  list.appendChild(conjunto);
  //SE CENTRA LA ESCRITURA EN EL INPUT
  codInput.focus();
  //LIMPIAMOS EL INPUT
  codInput.value = '';
  //SE ACTUALIZAN LOS CODIGOS EN EL HTML
  contador++;
  valor.textContent = contador;
  //SE ACTUALIZAN LAS PIEZAS EN EL HTML
  contadorP++;
  pieza.textContent = contadorP;
}



function cargarListaRegalo() {
  tr = "";


  for (var i = 0; i < arrayRegaloLista.length; i++) {
    // tr = document.createElement("tr");
    //td = document.createElement("td");
    // td.appendChild(document.createTextNode(arrayRegaloLista[i][0] + ": " + arrayRegaloLista[i][1]));
    tr = tr + "<tr class='mb-2'><td>" + arrayRegaloLista[i][0] + ": " + arrayRegaloLista[i][1] + "</td></tr>"
    // tr.appendChild(td);
    // table.appendChild(tr);
  }

  //listRegalo.innerHTML = tableA + tr + tableB;
  listRegalo.innerHTML = tr;


  //listRegalo.setAttribute("class", conjunto.createTextNode);
  cantidadRegalosGeneral();

}

function buscarEnArray(array, id) {
  //SE RECORRE EL ARRAY BUSCANDO EL CODIGO
  for (var i = 0; i < array.length; i++) {
    if (array[i][0] == id) {
      return i;
    }
  }
  return -1;
}
function buscarRegalo(reg) {
  for (var i = 0; i < arrayRegaloLista.length; i++) {

    if (arrayRegaloLista[i][0] == reg) {
      return i;
    }
  }
  return -1;
}



function regaloLista(reg, cantreg) {
  if (arrayRegaloLista.length > 0) {

    indice = buscarRegalo(reg);
    console.log(indice);
    if (indice >= 0) {
      arrayRegaloLista[indice][1] = arrayRegaloLista[indice][1] + cantreg;

      console.log(arrayRegaloLista);
    } else {
      arrayRegaloLista.push([reg, cantreg]);

      console.log(arrayRegaloLista);
    }
  } else {
    console.log("REGALO NUEVO - LISTA VACIA");

    arrayRegaloLista.push([reg, cantreg]);
  }

}


function eliminarProducto(a) {


  index = buscarEnArray(arrayPedido, a);

  console.log(arrayPedido[0][3]);


  for (let i = 0; i < arrayPedido[index][3].length; i++) {

    console.log(arrayPedido[index][3][i]);
    descontarRegalo(arrayPedido[index][3][i][0], arrayPedido[index][3][i][1]);

  }
  //DESCONTAR DEL GENERAL

  console.log(index);
  console.log(arrayPedido[index][2]);
  contadorP = contadorP - arrayPedido[index][2];
  pieza.textContent = contadorP;

  arrayPedido.splice(index, 1)
  console.log(arrayPedido);


  cargarListaRegalo();


  contador = contador - 1;
  valor.textContent = contador;


  del = document.getElementById(a);
  list.parentNode;
  list.removeChild(del)
  if (arrayPedido.length == 0) {
  }

}

function cantidadRegalosGeneral() {
  suma = 0;
  for (let i = 0; i < arrayRegaloLista.length; i++) {

    suma = suma + arrayRegaloLista[i][1];
  }
  valregalo.textContent = suma;
}


function descontarRegalo(reg, cant) {
  for (var i = 0; i < arrayRegaloLista.length; i++) {
    if (arrayRegaloLista[i][0] == reg) {
      arrayRegaloLista[i][1] = arrayRegaloLista[i][1] - cant;
      if (arrayRegaloLista[i][1] == 0) {
        arrayRegaloLista.splice(i, 1)
      }
    } else {
      console.log("no se encontró al regalo")
    }
  }
}




function saveLista() {
  if (arrayPedido.length > 0) {
    controlador = [];
    controlador.push("save");
    for (let i = 0; i < arrayPedido.length; i++) {
      controlador[1] = i + 1;


      controlador.push(arrayPedido[i][0]);
    }

    saveCarga(controlador);

  } else {

    alert('SU LISTA SE ENCUENTRA VACÍA');
  }

}

function saveCarga(controlador) {

  $.ajax({
    type: 'POST',
    url: 'recursos/funciones/arribo_fx.php',
    data: { controlador },
    datatype: { JSON },
    success: function (succesrespuesta) {
      console.log(succesrespuesta)
      let resp = JSON.parse(succesrespuesta);
      if (resp['errores'] > 0) {
        if (resp['errores'] == 1) {
          alert('Lista cargada con: ' + resp['errores'] + ' error.');

        } else {
          alert('Lista cargada con: ' + resp['errores'] + ' errores.');

        }
        location.reload();


      } else {
        alert('Lista cargada');
        location.reload();

      }
    }
  });

}

/*
function ActualizarLista(pedido) {
  // SE CREA EL ELEMENTO LI
  li = document.createElement("li");
  // SE PASA EL CODIGO A NODO DE TEXTO
  pedidotxt = document.createTextNode(pedido[0]
    +" ---- "+pedido[1]);
  //SE INGRESA EL NODO AL LI RECIEN CREADO
  li.appendChild(pedidotxt);
  //SE INGRESA EL LI CON EL NODO A LA LISTA "list" DEL HTML
  list.appendChild(li);
  //SE CENTRA LA ESCRITURA EN EL INPUT
  codInput.focus();
  //LIMPIAMOS EL INPUT
  codInput.value = '';
  //SE ACTUALIZAN LOS CODIGOS EN EL HTML
  contador++;
  valor.textContent = contador;
  //SE ACTUALIZAN LAS PIEZAS EN EL HTML
  contadorP++;
  pieza.textContent = contadorP;
}
*/
//EVENTO DEL CLICK EN EL BOTON CONFIRMAR



guardarLista.addEventListener('click', saveLista);




conf.addEventListener('click', addcod);



codInput.addEventListener('keypress', function (e) {
  if (e.key === 'Enter') {
    addcod();
  }
});