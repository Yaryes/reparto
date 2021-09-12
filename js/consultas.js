
var btnConsultora = document.getElementById('btnConsultora'),
    btnEncomienda = document.getElementById('btnEncomienda'),
    codEncomienda = document.getElementById('codEncomienda'),
    codConsultora = document.getElementById('codConsultora'),
    tablaPedidosConsultora = document.getElementById('tablaPedidosConsultora'),
    backConsultora = document.getElementById('backConsultora'),
    nombreConsultora = document.getElementById('nombreConsultora'),
    detalleConsultora = document.getElementById('detalleConsultora'),
    codigoConsultora = document.getElementById('codigoConsultora'),
    consultoraVista = document.getElementById('consultoraVista'),
    codigoEncomienda = document.getElementById('codigoEncomienda'),
    tablaPedidos = document.getElementById('tablaPedidos'),
    encomiendaVista = document.getElementById('encomiendaVista'),
    backPedido = document.getElementById('backPedido'),
    filtroTexto = document.getElementById('filtroTexto'),
    opcionMovimiento = document.getElementById('opcionMovimiento'),
    fechaConsultora = document.getElementById('fechaConsultora'),
    opcionMovimientoP = document.getElementById('opcionMovimientoP'),
    fechaEncomienda = document.getElementById('fechaEncomienda'),







    busqueda = document.getElementById('busqueda');

var arrayPedidos = [];



function buscaConsultora() {

    if (codConsultora.value != "") {
        controlador = [];
        controlador.push(codConsultora.value);
        controlador.push("cons");


        $.ajax({
            type: 'POST',
            url: 'recursos/funciones/consultas_fx.php',
            data: { controlador },
            datatype: { JSON },
            success: function (succesrespuesta) {

                let resp = JSON.parse(succesrespuesta);

                if (resp['existe']) {

                    busqueda.style.display = "none";
                    consultoraVista.style.display = "block";


                    nombreConsultora.textContent = resp['nombre_consultora'];
                    detalleConsultora.textContent = resp['direccion_consultora'] + " - " +
                        resp['telefono_consultora'] + " - " +
                        resp['sector_consultora'];

                    codigoConsultora.textContent = "CÓDIGO " + codConsultora.value;


                    for (let i = 0; i < resp['pedidos']['cantidad']; i++) {
                        pedidosConsultora(resp['pedidos'][i])
                    }

                } else {
                    window.alert("EL CÓDIGO NO EXISTE EN LA BASE DE DATOS")
                }




            }
        });

    } else {
        codConsultora.setAttribute('placeholder', 'DEBES INGRESAR UN CÓDIGO')


    }


}


function buscaEncomienda() {

    if (codEncomienda.value != "") {
        controlador = [];
        controlador.push(codEncomienda.value);
        controlador.push("enco");
        $.ajax({
            type: 'POST',
            url: 'recursos/funciones/consultas_fx.php',
            data: { controlador },
            datatype: { JSON },
            success: function (succesrespuesta) {
                    console.log(succesrespuesta);
                let resp = JSON.parse(succesrespuesta);
                if (resp['existe']) {




                    busqueda.style.display = "none";            // desactivas
                    encomiendaVista.style.display = "block";     // activas


                    codigoEncomienda.textContent = controlador[0]

                    for (let i = 0; i < resp['cantidad']; i++) {


                        conjunto = document.createElement("tr");
                        movimeintoTabla = document.createElement("td");
                        detalleTabla = document.createElement("td");
                        fechaHoraTabla = document.createElement("td");


                        movimeintoTabla.appendChild(document.createTextNode(resp[i]['estado_de_movimiento']));
                        fechaHoraTabla.appendChild(document.createTextNode(resp[i]['fecha']));

                        if (resp[i]['usuario_rut'] === null) {
                            detalleTabla.appendChild(document.createTextNode("Ruta: " + resp[i]['ruta_idruta']));
                            arrayPedidos.push({
                                pedido_idpedido: String(resp[i]['pedido_idpedido']),
                                estado_de_movimiento: resp[i]['estado_de_movimiento'],
                                fecha: resp[i]['fecha'],
                                usuario: String(resp[i]['ruta_idruta'])
                            });
                        } else {
                            detalleTabla.appendChild(document.createTextNode("RUT usuario: " + resp[i]['usuario_rut']));
                            arrayPedidos.push({
                                pedido_idpedido: String(resp[i]['pedido_idpedido']),
                                estado_de_movimiento: resp[i]['estado_de_movimiento'],
                                fecha: resp[i]['fecha'],
                                usuario: String(resp[i]['usuario_rut'])
                            });
                        }

                        conjunto.appendChild(movimeintoTabla);
                        conjunto.appendChild(detalleTabla);
                        conjunto.appendChild(fechaHoraTabla);
                        tablaPedidos.appendChild(conjunto);

                    }
                } else {
                    window.alert("CÓDIGO ERRÓNEO O SIN MOVIMIENTOS")
                }

            }
        });
    } else {
        codConsultora.setAttribute('placeholder', 'DEBES INGRESAR UN CÓDIGO')
    }
}



function pedidosConsultora(cod) {

    controlador = [];
    controlador.push(cod);
    controlador.push("pedid");
    $.ajax({
        type: 'POST',
        url: 'recursos/funciones/consultas_fx.php',
        data: { controlador },
        datatype: { JSON },
        success: function (succesrespuesta) {
            let resp = JSON.parse(succesrespuesta);
            console.log(resp);
            conjunto = document.createElement("tr");
            codigoTabla = document.createElement("td");
            movimeintoTabla = document.createElement("td");
            detalleTabla = document.createElement("td");
            fechaHoraTabla = document.createElement("td");
            if (resp['existe']) {




                codigoTabla.appendChild(document.createTextNode(resp['pedido_idpedido']));
                movimeintoTabla.appendChild(document.createTextNode(resp['estado_de_movimiento']));
                fechaHoraTabla.appendChild(document.createTextNode(resp['fecha']));

                if (resp['usuario_rut'] === null) {
                    detalleTabla.appendChild(document.createTextNode("Ruta: " + resp['ruta_idruta']));
                    arrayPedidos.push({
                        pedido_idpedido: String(resp['pedido_idpedido']),
                        estado_de_movimiento: resp['estado_de_movimiento'],
                        fecha: resp['fecha'],
                        usuario: String(resp['ruta_idruta'])
                    });
                } else {
                    detalleTabla.appendChild(document.createTextNode(resp['usuario_rut']));
                    arrayPedidos.push({
                        pedido_idpedido: String(resp['pedido_idpedido']),
                        estado_de_movimiento: resp['estado_de_movimiento'],
                        fecha: resp['fecha'],
                        usuario: String(resp['usuario_rut'])
                    });
                }
                conjunto.appendChild(codigoTabla);
                conjunto.appendChild(movimeintoTabla);
                conjunto.appendChild(detalleTabla);
                conjunto.appendChild(fechaHoraTabla);
                tablaPedidosConsultora.appendChild(conjunto);




            } else {
                codigoTabla.appendChild(document.createTextNode(controlador[0]));
                movimeintoTabla.appendChild(document.createTextNode("SIN MOVIMIENTO"));
                fechaHoraTabla.appendChild(document.createTextNode("N/A"));
                detalleTabla.appendChild(document.createTextNode("N/A"));
                conjunto.appendChild(codigoTabla);
                conjunto.appendChild(movimeintoTabla);
                conjunto.appendChild(detalleTabla);
                conjunto.appendChild(fechaHoraTabla);
                tablaPedidosConsultora.appendChild(conjunto);
            }
        }
    });


}








/*

███████     ██     ██          ████████     ██████       ██████      ███████ 
██          ██     ██             ██        ██   ██     ██    ██     ██      
█████       ██     ██             ██        ██████      ██    ██     ███████ 
██          ██     ██             ██        ██   ██     ██    ██          ██ 
██          ██     ███████        ██        ██   ██      ██████      ███████ 
                                                                             
                                                                           
*/
function filtroText(txt, llamada, tab) {

    switch (llamada) {
        case 1:
            codigos = [];
            for (let i = 0; i < arrayPedidos.length; i++) {
                codigos.push(arrayPedidos[i]['pedido_idpedido']);
            }
            elem = 'pedido_idpedido';
            filtrados = codigos.filter(item => item.indexOf(txt) > -1);
            table = tablaPedidosConsultora;

            break;
        case 2:
            codigos = [];
            for (let i = 0; i < arrayPedidos.length; i++) {
                codigos.push(arrayPedidos[i]['estado_de_movimiento']);
            }
            elem = 'estado_de_movimiento';
            filtrados = [txt];
            table = tab;

            break;
        case 3:
            codigos = [];
            for (let i = 0; i < arrayPedidos.length; i++) {
                codigos.push(arrayPedidos[i]['fecha']);
            }
            elem = 'fecha';
            filtrados = [txt];
            table = tab;
            break;


        default:
            break;
    }
    clear(table);
    for (let i = 0; i < filtrados.length; i++) {

        encontrados = buscarCod(elem, filtrados[i]);

        for (let t = 0; t < encontrados.length; t++) {
            load(encontrados[t], table);
        }
    }
}



function buscarCod(elem, cod) {
    encontrados = [];

    if (elem == 'fecha') {
        for (let i = 0; i < arrayPedidos.length; i++) {
            if (arrayPedidos[i][elem].split(" ")[0] == cod) {
                encontrados.push(i);
            }
        }
        return encontrados;
    } else {
        for (let i = 0; i < arrayPedidos.length; i++) {
            if (arrayPedidos[i][elem] == cod) {
                encontrados.push(i);
            }
        }
        return encontrados;
    }

}




/*

 █████       ██████     ████████     ██    ██      █████      ██          ██     ███████      █████      ██████       ██████      ██████      ███████     ███████ 
██   ██     ██             ██        ██    ██     ██   ██     ██          ██        ███      ██   ██     ██   ██     ██    ██     ██   ██     ██          ██      
███████     ██             ██        ██    ██     ███████     ██          ██       ███       ███████     ██   ██     ██    ██     ██████      █████       ███████ 
██   ██     ██             ██        ██    ██     ██   ██     ██          ██      ███        ██   ██     ██   ██     ██    ██     ██   ██     ██               ██ 
██   ██      ██████        ██         ██████      ██   ██     ███████     ██     ███████     ██   ██     ██████       ██████      ██   ██     ███████     ███████
*/






function load(index, tabla) {

    conjunto = document.createElement("tr");
    movimeintoTabla = document.createElement("td");
    detalleTabla = document.createElement("td");
    fechaHoraTabla = document.createElement("td");
    if (tabla.id == tablaPedidosConsultora.id) {
        codigoTabla = document.createElement("td");

        codigoTabla.appendChild(document.createTextNode(arrayPedidos[index]['pedido_idpedido']));
        conjunto.appendChild(codigoTabla);

    }

    movimeintoTabla.appendChild(document.createTextNode(arrayPedidos[index]['estado_de_movimiento']));
    fechaHoraTabla.appendChild(document.createTextNode(arrayPedidos[index]['fecha']));
    detalleTabla.appendChild(document.createTextNode("Ruta: " + arrayPedidos[index]['usuario']));

    conjunto.appendChild(movimeintoTabla);
    conjunto.appendChild(detalleTabla);
    conjunto.appendChild(fechaHoraTabla);
    tabla.appendChild(conjunto);
}
function clear(tabla) {
    while (tabla.firstChild) {
        tabla.removeChild(tabla.firstChild);
    }
}















/*
██████      ███████     ███████     ███████     ████████     
██   ██     ██          ██          ██             ██        
██████      █████       ███████     █████          ██        
██   ██     ██               ██     ██             ██        
██   ██     ███████     ███████     ███████        ██        
                                                      
*/

function resetearRegistro() {
    while (tablaPedidosConsultora.firstChild) {
        tablaPedidosConsultora.removeChild(tablaPedidosConsultora.firstChild);
    }
    codigoConsultora.textContent = "";
    detalleConsultora.textContent = "";
    nombreConsultora.textContent = "";

    busqueda.style.display = "block";
    consultoraVista.style.display = "none";

    listas();




}


function resetearPedido() {
    while (tablaPedidos.firstChild) {
        tablaPedidos.removeChild(tablaPedidos.firstChild);
    }
    codigoEncomienda.textContent = "";

    busqueda.style.display = "block";
    encomiendaVista.style.display = "none";
    listas();
}



function listas() {
    i = 0
    while (arrayPedidos.length > 0) {
        arrayPedidos.splice(i, 1)
        i = i++;
    }
    t = 0
    while (codigos.length > 0) {
        codigos.splice(t, 1)
        t = t++;
    }
}









/*

██          ██     ███████     ████████     ███████     ███    ██     ███████     ██████      
██          ██     ██             ██        ██          ████   ██     ██          ██   ██     
██          ██     ███████        ██        █████       ██ ██  ██     █████       ██████      
██          ██          ██        ██        ██          ██  ██ ██     ██          ██   ██     
███████     ██     ███████        ██        ███████     ██   ████     ███████     ██   ██     

*/

btnEncomienda.addEventListener('click', buscaEncomienda);

codEncomienda.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        buscaEncomienda();
    }
});

btnConsultora.addEventListener('click', buscaConsultora);

codConsultora.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        buscaConsultora();
    }
});


backConsultora.addEventListener('click', resetearRegistro);

backPedido.addEventListener('click', resetearPedido);







//////FILTROS
//INPUT
filtroTexto.addEventListener('keyup', function f1() {
    opcionMovimiento.value = "MOVIMIENTO";
    fechaConsultora.value = "";
    a = filtroTexto.value.replace(/\s+/g, '');
    filtroText(a, 1);
});
//COMBO BOX
opcionMovimiento.addEventListener('change', function f2() {

    filtroTexto.value = "";
    fechaConsultora.value = "";
    a = opcionMovimiento.value;

    if (a == "TODOS") {
        clear(tablaPedidosConsultora)
        for (let i = 0; i < arrayPedidos.length; i++) {
            load(i, tablaPedidosConsultora);
        }
    } else {
        filtroText(a, 2, tablaPedidosConsultora);
    }

});
//DATE
fechaConsultora.addEventListener('change', function f3() {
    filtroTexto.value = "";
    opcionMovimiento.value = "MOVIMIENTO";
    a = fechaConsultora.value.split(" ")[0].split("-").reverse().join("-");
    filtroText(a, 3), tablaPedidosConsultora;

});


opcionMovimientoP.addEventListener('change', function f4() {
    fechaEncomienda.value = "";
    a = opcionMovimientoP.value;

    if (a == "TODOS") {
        clear(tablaPedidos)
        for (let i = 0; i < arrayPedidos.length; i++) {
            load(i, tablaPedidos);
        }
    } else {
        filtroText(a, 2, tablaPedidos);
    }

});
fechaEncomienda.addEventListener('change', function f3() {
    opcionMovimientoP.value = "MOVIMIENTO";
    a = fechaEncomienda.value.split(" ")[0].split("-").reverse().join("-");
    filtroText(a, 3, tablaPedidos);

});