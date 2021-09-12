const recepcionRuta = {
  ruta: null,
  repartidor: null,
  pedidos: [],
  regalos: {},
  retiros: []
}

let pedidos = []
let retiros = []

async function getRuta(e) {
  e.preventDefault()

  const inputRuta = document.getElementById('cod-ruta')

  //cambiar ruta /reparto2/reparto/recursos/controllers/rutas.php?ruta= dependiendo donde este alojada la carpeta
  const response = await fetch(`/reparto/recursos/controllers/rutas.php?ruta=${inputRuta.value}&pedidos=1&retiros=1`)

  const { id, repartidor, hasMovements, pedidos, retiros } = await response.json()

  if (id) {
    recepcionRuta['ruta'] = id
    recepcionRuta['repartidor'] = repartidor
    recepcionRuta['pedidos'] = pedidos.filter((pedido) => pedido.state === 'SALIDA A RUTA' && !pedido.entrega)
    recepcionRuta['retiros'] = retiros.filter((retiro) => retiro.movimiento === 'SALIDA A RUTA' && !retiro.entrega)

    document.getElementById('cod-pedido').removeAttribute('disabled')
    document.getElementById('confirmar-codigo').removeAttribute('disabled')
    document.getElementById('reset-codigo').removeAttribute('disabled')
  } else {
    alert('Ruta no existe')
    document.getElementById('cod-ruta').value = ""
  }

  buildRegalos()
  renderNoEntregadosTable('table-no-entregados')
}

function getPedido(e) {
  e.preventDefault()

  const inputPedido = document.getElementById('cod-pedido')
  const foundPedido = recepcionRuta.pedidos.find(pedido => pedido.idPedido == inputPedido.value)

  if (foundPedido) {

    pedidos = [...pedidos, foundPedido]
    recepcionRuta['pedidos'] = recepcionRuta.pedidos.filter(pedido => pedido.idPedido != inputPedido.value)

    renderNoEntregadosTable('table-no-entregados')
    renderPedidosTable()
  }
}

function buildRegalos() {
  const newRegalos = {}
  recepcionRuta.pedidos.forEach(pedido => {
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
  recepcionRuta.regalos = newRegalos
}

function renderPedidos() {
  const tablePedidos = pedidos.map((pedido) => buildPedidoRow(pedido.idPedido, pedido.adress)).join('')
  document.getElementById('table-entregados').innerHTML = tablePedidos
}

function buildPedidoRow(pedido, direccion) {
  return `<tr><td>${pedido}</td><td>${direccion}</td><td><button onclick=devolverPedido(${pedido})><-</button></td></tr>`
}

function devolverPedido(idPedido) {
  pedido = pedidos.find(pedido => pedido.idPedido == idPedido)
  pedidos = pedidos.filter(pedido => pedido.idPedido != idPedido)
  recepcionRuta['pedidos'] = [...recepcionRuta.pedidos, pedido]



  renderNoEntregadosTable('table-no-entregados')
  renderPedidosTable()
}

function renderNoEntregadosTable(tableName) {
  const piezas = recepcionRuta.pedidos.reduce((p, c) => p + c.pieces, 0)
  renderRetirosEnRuta(tableName)
  document.getElementById('os-no-entregados').innerText = `OS: ${recepcionRuta.pedidos.length}`
  document.getElementById('piezas-no-entregados').innerText = `Piezas: ${piezas}`
}

function renderRetirosEnRuta(tableName) {
  const tableRetiros = recepcionRuta.pedidos.map((pedido) => buildPedidoNoEntregadoRow(pedido.idPedido, pedido.adress)).join('')
  document.getElementById(tableName).innerHTML = tableRetiros
}

function buildPedidoNoEntregadoRow(pedido, direccion) {
  return `<tr><td>${pedido}</td><td>${direccion}</td></tr>`
}

function renderRegalos() {
  const tableRegalos = Object.keys(recepcionRuta.regalos).map((regalo) => buildRegalosRow(regalo, recepcionRuta.regalos[regalo].cantidad)).join('')
  document.getElementById('table-regalos-2').innerHTML = tableRegalos
}

function buildRegalosRow(regalo, cantidad = 0) {
  return `<tr><td>${regalo}</td><td>${cantidad}</td></tr>`
}


function renderPedidosTable() {
  const piezas = pedidos.reduce((p, c) => p + c.pieces, 0)
  renderPedidos()
  document.getElementById('os-entregados').innerText = `OS: ${pedidos.length}`
  document.getElementById('piezas-entregados').innerText = `Piezas: ${piezas}`
}

const formRuta = document.getElementById('get-ruta');

formRuta.addEventListener('submit', getRuta);


const formPedido = document.getElementById('get-pedido');
formPedido.addEventListener('submit', getPedido);

function firstStep() {
  document.getElementById('first-step').classList.add('d-none');
  document.getElementById('second-step').classList.remove('d-none');
  const routeNameEl = document.getElementById('route-name');
  routeNameEl.innerText = recepcionRuta.ruta

  buildRegalos()
  renderNoEntregadosTable('table-no-entregados-2')
  renderRegalos()
  renderRetiros()
}

function renderRetiros() {
  const tableRetiros = recepcionRuta.retiros.map((retiro) => buildRetiroRow(retiro.idRetiro, retiro.direccion, retiro.movimiento)).join('')
  document.getElementById('table-retiros').innerHTML = tableRetiros
}

function buildRetiroRow(retiro, direccion, movimiento) {
  const checked = movimiento == 'SALIDA A RUTA' ? null : 'checked'
  return `<tr><td>${retiro}</td><td>${direccion}</td><td><input type="checkbox" onclick=toggleRetiro(${retiro}) ${checked}/></td></tr>`
}

function toggleRetiro(idRetiro) {
  recepcionRuta.retiros = recepcionRuta.retiros.map((retiro) => retiro.idRetiro == idRetiro ? { ...retiro, entregado: true } : retiro)
}

function secondStep() {
  document.getElementById('second-step').classList.add('d-none');
  document.getElementById('third-step').classList.remove('d-none');
  renderMacros()
  renderRetirosNoEfectuados()
  renderRetirosEnRuta('table-no-entregados-3')
}

function renderRetirosNoEfectuados() {
  const retirosNoEfectuados = recepcionRuta.retiros.filter((retiro) => !retiro?.entregado)
  const tableRetiros = retirosNoEfectuados.map((retiro) => buildRetiroNoEfectuadoRow(retiro.idRetiro, retiro.direccion)).join('')
  document.getElementById('table-retiro-no-efectuado').innerHTML = tableRetiros
}

function buildRetiroNoEfectuadoRow(retiro, direccion) {
  return `<tr><td>${retiro}</td><td>${direccion}</td></tr>`
}

function renderMacros() {
  const osEl = document.getElementById('os-entregas');
  const piezaEl = document.getElementById('piezas-entregas');
  const regalosEl = document.getElementById('regalos-entregas');
  const notOsEl = document.getElementById('os-no-entregas');
  const notPiezaEl = document.getElementById('piezas-no-entregas');
  const notRegalosEl = document.getElementById('regalos-no-entregas');

  const os = pedidos.length
  const piezas = pedidos.reduce((p, c) => p + c.pieces, 0)
  const regalos = pedidos.reduce((p, c) => p + c?.regalos.reduce((p, c) => p + c.cantidad, 0), 0)
  const notOs = recepcionRuta.pedidos.length
  const notPiezas = recepcionRuta.pedidos.reduce((p, c) => p + c.pieces, 0)
  const notRegalos = recepcionRuta.pedidos.reduce((p, c) => p + c?.regalos.reduce((p, c) => p + c.cantidad, 0), 0)

  osEl.innerText = `OS: ${os}`
  piezaEl.innerText = `Piezas: ${piezas}`
  regalosEl.innerText = `Regalos: ${regalos}`
  notOsEl.innerText = `OS: ${notOs}`
  notPiezaEl.innerText = `Piezas: ${notPiezas}`
  notRegalosEl.innerText = `Regalos: ${notRegalos}`
}

async function submitRecepcion() {

  const pedidosEntregados = pedidos.map((pedido) => ({ id: pedido.idPedido, estado: 'ENTREGADO' }))
  const pedidosNoEntregados = recepcionRuta.pedidos.map((pedido) => ({ id: pedido.idPedido, estado: 'BODEGA' }))
  const pedidosFinales = [...pedidosEntregados, ...pedidosNoEntregados]

  const retirosEfectuados = recepcionRuta.retiros.map((retiro) => retiro.entregado ? { id: retiro.idRetiro, estado: 'ENTREGADO' } : { id: retiro.idRetiro, estado: 'BODEGA' })

  const body = {
    ruta: recepcionRuta.ruta,
    pedidos: pedidosFinales,
    retiros: retirosEfectuados
  }
  const response = await fetch(`/reparto/recursos/controllers/recepcion_ruta.php`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(body)
  })

  if (response.status == 200){
    document.getElementById('third-step').classList.add('d-none');
    document.getElementById('end-step').classList.remove('d-none');
  }

}