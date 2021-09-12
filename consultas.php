<?php
session_start();
if($_SESSION ['user']['rut']!=null){
include('templates/header.php');
include('templates/menu.php');
?>
<!--PRIMERA PARTE-->
<div class="container-fluid" >
    <div class="form-row  p-5  m-5 bg-white" style="display: block;border-radius: 35px;box-shadow: 0 0px 5px 0;" id="busqueda">
        <div class="col-12 mt-4 mb-3" style="text-align: center; "> 
            <h3>CONSULTAS</h3>
        </div>
        <!--INGRESO CODIGOS Y BOTONES-->
        <div class="col-12 input-group mt-5 ">
            <input type="text" class=" form-control mr-5 ml-5 mt-5 mb-5" placeholder="Ingrese código de consultora" 
                style="border-radius: 35px; border-color:#2B39E7;" id="codConsultora">
            <button class="btn btn-primary mr-3 mt-5 mb-5 "style="width: 20%;border-radius: 35px;" 
                type="button"id="btnConsultora">Confirmar
            </button>
        </div>
        <div class="col-12 input-group mb-5">
            <input type="text" class="form-control mr-5 ml-5 mt-5 mb-5" placeholder="Ingrese código de encomienda" 
                style="border-radius: 35px; border-color:#2B39E7" id="codEncomienda">
            <button class="btn btn-primary mr-3 mt-5 mb-5 "style="width: 20%;border-radius: 35px;" 
                type="button"id="btnEncomienda">Confirmar
            </button>
        </div>
    </div>
</div>
<!--SEGUNDA PARTE VISTA DE LA CONSULTORA-->
<div class="container-fluid" >
    <div  class="form-row  p-5  m-5 bg-white" style="display: none;border-radius: 35px;box-shadow: 0 0px 5px 0; height: 700px"
            id="consultoraVista">
        <!--DETALLE CONSULTA-->
        <div class="col-12 mt-4 mb-3" style="text-align: center;">
            <h1>Detalle de Consultora</h1>
        </div>
        <div class="col-12 mt-4 mb-3" style="text-align: center;"><b>
            
            <label id="nombreConsultora"></label>
            <br>
            <label id="codigoConsultora"></label>
            <br>
            <label id="detalleConsultora"></label>
        </div>
        <!--BOTONES-->
        <div class="row">
            <div class="col-4 " style="text-align: center">
                <input  class="rounded-pill border-primary form-control" placeholder="Ingresa un código"  
                        type="text" id="filtroTexto">
            </div>     
            <div class="col-4" style="text-align: center;">   
                <select  class="rounded-pill border-primary form-control" name="" id="opcionMovimiento">
                    <option hidden selected>MOVIMIENTO</option>
                    <option value="TODOS">TODOS</option>
                    <option value="ARRIBADO">ARRIBADO</option>
                    <option value="SALIDA A RUTA">SALIDA A RUTA</option>
                    <option value="ENTREGADO">ENTREGADO</option>
                    <option value="REGRESO A BODEGA">REGRESO A BODEGA</option>
                </select>
            </div> 
            <div class="col-4 " style="text-align: center;">  
                <input class="rounded-pill border-primary form-control" type="date" name="" id="fechaConsultora">
            </div> 
        </div>
        <!--TABLA DE LA CONSULTORA-->
        <div class="col-12 mt-5" >
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Códigos de encomienda</th>
                        <th scope="col">Último movimiento</th>
                        <th scope="col">Detalle</th>
                        <th scope="col">Fecha y Hora</th>
                    </tr>
                </thead>
                <tbody id="tablaPedidosConsultora"value="0">
                </tbody>  
            </table>
        </div>
         <!--BOTON OTRA CONSULTA-->
        <div class="col-12 mt-5 text-center" >
            <button class="btn btn-primary text-center" style="border-radius: 35px" id="backConsultora">Realizar otra consulta</button>
        </div>
    </div>
</div>
<!--TERCERO PARTE VISTA DE LA CONSULTORA-->
<div class="container-fluid"> 
    <div class="form-row  p-5  m-5 bg-white" style="display: none;border-radius: 35px;box-shadow: 0 0px 5px 0; height: 700px"
            id="encomiendaVista">           
        <!--DETALLE CONSULTA-->
        <div class="col-12 mt-4 mb-3" style="text-align: center;">
            <h1>Detalle de Encomienda</h1>
            <label class="h2"  id="codigoEncomienda"></label>
        </div>
        <!--BOTONES DE CONSULTA-->
        <div class="row mt-4">
            <div class="col-6" style="text-align: center">
                <select class="rounded-pill border-primary form-control" name="" id="opcionMovimientoP">
                    <option hidden selected>MOVIMIENTO</option>
                    <option value="TODOS">TODOS</option>
                    <option value="ARRIBADO">ARRIBADO</option>
                    <option value="SALIDA A RUTA">SALIDA A RUTA</option>
                    <option value="ENTREGADO">ENTREGADO</option>
                    <option value="REGRESO A BODEGA">REGRESO A BODEGA</option>
                </select>
            </div>
            <div class="col-6" style="text-align: center">
                <input class=" rounded-pill border-primary form-control" type="date" id="fechaEncomienda">
            </div>
        </div>
        <!--TABLA DE CONSULTA-->
        <div class="col-12 mt-5" >
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Movimiento</th>
                        <th scope="col">Detalle</th>
                        <th scope="col">Fecha y Hora</th>
                    </tr>
                </thead>
                <tbody id="tablaPedidos">
                </tbody>
        </table>
        </div>
        <div class="col-12 mt-5 text-center">
            <button class="btn btn-primary text-center" style="border-radius: 35px" 
                id="backPedido">Realizar otra consulta
            </button>
        </div>
    </div>
</div>
<script src="js/consultas.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php include('templates/footer.php');
}else{
    header('Location: index.html'); 
 }
?>