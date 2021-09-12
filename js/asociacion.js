//INICIALIZACIÓN DE VARIABLES
let contador = 0;
//VARIABLES DE LA PRIMERA PARTE
var codInput = document.getElementById('codInput'),
    lista = document.getElementById('lista'),
    conf = document.getElementById('conf');
busqueda = document.getElementById('busqueda');
posicion = document.getElementById('posicion');
vista1 = document.getElementById('vista1');
posicionh1 = document.getElementById('posicionh1');


//VARIABLES DE LA SEGUNDA PARTE
var codInput2 = document.getElementById('codInput2'),
    confPedido = document.getElementById('confPedido'),
    valor2 = document.getElementById('cod2');
fin = document.getElementById('fin');
var array = [];
//CONSULTA PRIMERA PARTE
var addcod = function () {
    var codigo = codInput.value;
    if (codigo != "") {
        $.ajax({
            type: 'POST',
            url: 'recursos/funciones/asociacion_fx.php',
            data: { codigo },
            datatype: { JSON },
            success: function (succesrespuesta) {
                let resp = JSON.parse(succesrespuesta);
                if (resp['existe']) {
                    if (array.length <= 0) {
                        array.push([]);
                        array[0][0] = codigo;
                        array[0][1] = resp['direccion'];
                        //LLEVA EL ARRAY
                        //SE ACTUALIZA LA LISTA DEL HTML
                        ActualizarLista(array[0]);
                    } else {
                        if (buscarEnArray(array, codigo) == -1) {
                            array.push([codigo, resp['direccion']])
                            ActualizarLista(array[array.length - 1]);
                        } else {
                            alert("CÓDIGO YA INGRESADO");
                        }
                    }
                } else {
                    alert("Codigo erróneo o no registrado");
                }
            }
        });
    } else {
        codInput.setAttribute("placeholder", "Ingrese un código");
    }
}
//METODOS 
function buscarEnArray(array, id) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][0] == id) {

            // + 1 ?
            return i;
        }
    }
    return -1;
}
function ActualizarLista(pedido) {
    for (let index = 0; index < pedido.length; index++) {
    }
    // SE CREA EL ELEMENTO LI
    li = document.createElement("li");
    li.setAttribute("class", "list-group-item col-10 m-1");
    li.setAttribute("id", pedido[0])
    btn = document.createElement("button");
    btn.appendChild(document.createTextNode("ELIMINAR"));
    btn.setAttribute("class", "btn btn-danger col m-1");
    //AGREGAR METODO ELIMINAR 
    btn.setAttribute("onclick", "eliminarProducto(this.id)");
    btn.setAttribute("id", pedido[0])
    pedidotxt = document.createTextNode("Codigo: " + pedido[0]
        + " --> Dirección: " + pedido[1]);
    //SE INGRESA EL NODO AL LI RECIEN CREADO
    li.appendChild(pedidotxt);
    //SE INGRESA EL LI CON EL NODO A LA LISTA "list" DEL HTML
    lista.appendChild(li);
    lista.appendChild(btn);
    //lista.appendChild(btn);
    //SE CENTRA LA ESCRITURA EN EL INPUT
    codInput.focus();
    //LIMPIAMOS EL INPUT
    codInput.value = '';
}

function eliminarProducto(p) {
    index = buscarEnArray(array, p);
    array.splice(index, 1);
    del = document.getElementById(p);
    lista.parentNode;
    lista.removeChild(del);
    del = document.getElementById(p);
    lista.parentNode;
    lista.removeChild(del);


}

conf.addEventListener('click', addcod);
//CONSULTA SEGUNDA PARTE
var bqcod = function () {
    var codigo = codInput2.value;
    if (codigo != "") {

        codigob=buscarEnArray(array, codigo)
        if (codigob!=-1) {
            posicionh1.textContent=codigo;
            valor2.textContent = codigob+1;
        } else {
            posicionh1.textContent="CÓDIGO NO REGISTRADO EN LA LISTA";
            valor2.textContent=":("
        }

    } else {
        codInput.setAttribute("placeholder", "Ingrese un código");
    }
}
confPedido.addEventListener('click', bqcod);
var asd = function () {
    if (!array.length) {
        alert("SU LISTA SE ENCUENTRA VACÍA");
    } else {
        var codigo = posicion.value;
        if (codigo != "confirmar") {
            busqueda.style.display = "contents";
            vista1.style.display = "none";
        }
    }
}
posicion.addEventListener('click', asd);
var close = function () {
    alert("La lista de Asociación se cerrará");
    location.href = "asociacion.php";
}
fin.addEventListener('click', close);