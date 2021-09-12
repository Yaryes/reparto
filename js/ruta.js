const salidaRuta = {
  ruta: null,
  repartidor: null,
  pedidos: [],
  regalos: {}
}

async function postSalidaRuta() {
  const response = await fetch(`/reparto/recursos/controllers/salida_ruta.php`, {
      method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(salidaRuta)
  })

  salidaRuta.ruta = null
  salidaRuta.repartidor = null
  salidaRuta.pedidos = []
  salidaRuta.regalos = {}

  document.getElementById('cod-ruta').value = ""
  document.getElementById('cod-pedido').setAttribute('disabled', "")
  document.getElementById('cod-pedido').value = ''

  renderView()

}

async function getRuta(e) {
  e.preventDefault()

  const inputRuta = document.getElementById('cod-ruta')

  //cambiar ruta /reparto2/reparto/recursos/controllers/rutas.php?ruta= dependiendo donde este alojada la carpeta
  const response = await fetch(`/reparto/recursos/controllers/rutas.php?ruta=${inputRuta.value}`)

  const { id, repartidor, hasMovements } = await response.json()

  if (!hasMovements) {
    if (id) {
      salidaRuta['ruta'] = id
      salidaRuta['repartidor'] = repartidor

      document.getElementById('cod-pedido').removeAttribute('disabled')
      document.getElementById('confirmar-codigo').removeAttribute('disabled')
      document.getElementById('reset-codigo').removeAttribute('disabled')
    } else {
      alert('Ruta no existe')
      document.getElementById('cod-ruta').value = ""
    }
  } else {
    alert(`Ruta tiene ${hasMovements} movimientos. No se puede agregar`)
  }

}

async function getPedido(e) {
  e.preventDefault()

  const inputPedido = document.getElementById('cod-pedido')


  const response = await fetch(`/reparto/recursos/controllers/pedidos.php?pedido=${inputPedido.value}`)

  const { id, direccion, piezas, campana, regalos, retiros, idconsultora, estadoPedido } = await response.json()


  if (!!id) {
    if (!salidaRuta.pedidos.find((pedido) => pedido.id === id)) {
      if (estadoPedido != "SALIDA A RUTA" ) {
        salidaRuta.pedidos.push({
          id: id,
          idconsultora: idconsultora,
          direccion: direccion,
          piezas: piezas,
          campana: campana,
          regalos: regalos,
          retiros: retiros
        })
      } else {
        alert(`El Pedido se encuentra en reparto`)
      }
    }
    else {
      alert('Codigo ya ingresado')
    }
  } else {
    alert('Codigo no existe')
  }
  renderView()
}

function renderDirecciones() {
  const tableDirecciones = salidaRuta.pedidos.map((pedido) => buildDireccionesRow(pedido.id, pedido.direccion)).join('')
  document.getElementById('table-direcciones').innerHTML = tableDirecciones
}

function renderRegalos() {
  const tableRegalos = Object.keys(salidaRuta.regalos).map((regalo) => buildRegalosRow(regalo, salidaRuta.regalos[regalo].cantidad)).join('')
  document.getElementById('table-regalos').innerHTML = tableRegalos
}

function renderRetiros() {
  const tableRetiros = salidaRuta.pedidos.map((pedido) => pedido.retiros.map((retiro) => buildRetirosRow(retiro.id, pedido.direccion))).join('')
  document.getElementById('table-retiros').innerHTML = tableRetiros
}

function buildRegalos() {
  const newRegalos = {}
  salidaRuta.pedidos.forEach(pedido => {
    pedido.regalos.forEach(regalo => {
      if (newRegalos[regalo.regalo]) {
        newRegalo = newRegalos[regalo.regalo]
        newRegalos[regalo.regalo] = {
          cantidad: regalo.cantidad + newRegalo.cantidad,
          id: regalo.id
        }
      } else {
        newRegalos[regalo.regalo] = {
          cantidad: regalo.cantidad,
          id: regalo.id
        }
      }
    })
  });
  salidaRuta.regalos = newRegalos
}

function deletePedido(idPedido) {
  const filteredPedidos = salidaRuta.pedidos.filter((pedido) => pedido.id !== idPedido)
  salidaRuta.pedidos = filteredPedidos
  renderView()
}

function buildDireccionesRow(pedido, direccion) {
  return `<div><tr><td>${pedido}</td><td>${direccion}</td><td><button class="btn btn-outline-light" onclick="deletePedido(${pedido})"><img src="/reparto/img/trash-fill.svg" alt="Bootstrap" width="32" height="32"> </button></td></tr></div>`
}

function buildRetirosRow(retiro, direccion) {
  return `<tr><td>${retiro}</td><td>${direccion}</td></tr>`
}

function buildRegalosRow(regalo, cantidad = 0) {
  return `<tr><td>${regalo}</td><td>${cantidad}</td></tr>`
}

const formRuta = document.getElementById('get-ruta');
formRuta.addEventListener('submit', getRuta);

const formPedido = document.getElementById('get-pedido');
formPedido.addEventListener('submit', getPedido);

const btnSalidaRuta = document.getElementById('btnSalidaRuta');
btnSalidaRuta.addEventListener('click', postSalidaRuta);

function renderView() {
  const cantidadPiezas = salidaRuta.pedidos.reduce((prev, pedido) => prev + pedido.piezas, 0)
  const allRetiros = salidaRuta.pedidos.reduce((prev, pedido) => prev + pedido.retiros.length, 0)
  const allRegalos = salidaRuta.pedidos.map((pedido) => pedido.regalos).flat()
  const cantidadRegalos = allRegalos.reduce((prev, curr) => prev + curr.cantidad, 0)



  document.getElementById('cods').innerText = salidaRuta.pedidos.length
  document.getElementById('piezas').innerText = cantidadPiezas
  document.getElementById('regalos').innerText = cantidadRegalos
  document.getElementById('retiros').innerText = allRetiros

  buildRegalos()
  renderDirecciones()
  renderRegalos()
  renderRetiros()
}