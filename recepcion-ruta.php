<?php
session_start();
if ($_SESSION['user']['rut'] != null) {
  include('templates/header.php');
  include('templates/menu.php');

?>
  <!--MODULO PRIMERA PARTE-->
  <body>
    <div id='first-step'>
      <div class="container-fluid">
        <div style="display: block;border-radius: 35px;box-shadow: 0 0px 5px 0;" class="form-row  p-5  m-5 bg-white">
          <div class=" text-center">
            <h1>Recepcion de Ruta</h1>
          </div>
          <!--BOTONES DE CONFIRMAR E INPUT-->
          <div class="row p-2">
            <div class="col-6 p-2 mt-3">
              <form id="get-ruta">
                <input class="ml-5 " placeholder="Ingrese Ruta" style="border-radius: 40px; border-color:#2B39E7;width: 50%;" type="text" id="cod-ruta" value="">
                <button class="btn btn-primary mr-3 " style="width: 20%;border-radius: 35px" id="conf" type="submit">Confirmar</button>
              </form>
            </div>
            <div class="col-6  mt-3">
              <form id="get-pedido">
                <input class="ml-5 mt-3" placeholder="Ingrese Código" style="width: 50%;border-radius: 40px; border-color:#2B39E7" type="text" id="cod-pedido" value="" disabled>
                <button class="btn btn-primary mr-3 " style="margin-left: 10px;width: 20%;border-radius: 35px" style="width: 20%;
                    border-radius: 35px" disabled id="confirmar-codigo" >Confirmar</button>
                <button class="boton clean rounded-pill bg-warning font-weight-bold text-white" id="reset-codigo" type="reset" disabled type="submit">Limpiar</button>
              </form>
            </div>
          </div>     
          <!--TABLAS-->
          <div class="row">
                <!--TABLAS NO ENTREGADOS-->
                <div class="col" style="margin-top: 35px; height: 350px;">
                    <h5 class=" text-center"> NO ENTREGDOS</h5>
                    <div class="pt-3" style="border: 1px solid #2B39E7; height: 300px;overflow:auto;">
                        <table class="table mt-4">
                            <tbody id="table-no-entregados">
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--TABLAS DE ENTREGADOS-->
                <div class="col" style="margin-top: 35px; height: 350px;">
                    <h5 class=" text-center">ENTREGADOS</h5>
                    <div class="pt-3" style=" border: 1px solid #2B39E7; height: 300px;overflow:auto;">
                        <table class="table mt-4">
                          <tbody id="table-entregados">
                          </tbody>
                        </table>
                    </div>
                </div>
          </div>
          <!--CONTADORES-->
          <div class="row font-weight-bold">
              <div class="col-6 border rounded m-1">
                <div>
                  <h2 id="os-no-entregados">OS: </h2>
                  <h2 id="piezas-no-entregados">Piezas: </h2>
                </div>
              </div>
              <div class="col-5 border rounded m-1">
                  <div>
                    <h2 id="os-entregados">OS: </h2>
                    <h2 id="piezas-entregados">Piezas: </h2>
                  </div>
              </div>
          </div>
          <div class="col-12 text-center mt-5">
            <button class="btn btn-primary text-center" style="border-radius: 35px;width: 200px;"  id="step-1" onclick=firstStep()>Avanzar</button>
          </div>
        </div>
      </div>  
    </div> 
<!--MODULO SEGUNDA PARTE-->    
    <div id="second-step" class="d-none">
      <div class="container-fluid">
        <div style="display: block;border-radius: 35px;box-shadow: 0 0px 5px 0;" class="form-row  p-5  m-5 bg-white">                
          <h1 class="text-center">Ruta</h1>
          <h1 class="text-center" id="route-name"></h1>
          <div class="row">
                <div class="col-12">
                <h4 class="text-center mt-4">No entregados</h4>
                </div>
                <!--TABLASSSSSSSS-->
                <div class="col-6 mt-2" style=" height: 300px;">
                    <div class="" style="border: 1px solid #2B39E7; height: 250px;overflow:auto;">
                        <table class="table mt-4">
                            <tbody id="table-no-entregados-2">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-6 mt-2" style=" height: 300px;">
                    <div class="pt-3" style=" border: 1px solid #2B39E7; height: 250px;overflow:auto;">
                        <table class="table mt-4 " id="table-regalos-2">
                        </table>
                    </div>
                </div>
              <!--TABLA -->
              <div class="col-12">
              <h4 class="text-center mt-2">No entregados</h4>
                  <div class="col-12" style="border: 1px solid #2B39E7; height: 250px;overflow:auto;">
                    <table class="" align="center">
                    <tbody id="table-retiros">
                    </tbody>
                    </table>
                  </div>
              </div>
          </div>
          <!--BOTON SEGUIR -->
          <div class="col-12 text-center mt-5">
              <button class="btn btn-primary "  style="border-radius: 35px;width: 200px;" id="step-2" onclick=secondStep()>Avanzar</button>
          </div>
          </div>
        </div>
      </div>
    </div>
<!--MODULO TERCERA PARTE-->    
    <div id="third-step" class="d-none">
      <div style="display: block;border-radius: 35px;box-shadow: 0 0px 5px 0;" class="form-row  p-5  m-5 bg-white">
        <h1 class="text-center">Ruta</h1>
        <h1 id="route-name"></h1>
        <!--CONTADORES-->
        <div class="mt-4">
          <div class="row h2">
            <div class="col text-center ">
              <td></td>
            </div>
          <div class="col text-center">
            <td></td>
          </div>
          <div class="col text-center">
            <td></td>
          </div>
        </div>
        <div class="row display-1 font-weight-bold">
          <div class="col border border-primary rounded-pill text-center m-1">
            <td><span id="os-entregas"></span></td>
          </div>
          <div class="col border border-primary rounded-pill text-center m-1 ">
            <td><span id="piezas-entregas">0</span></td>
          </div>
          <div class="col border border-primary rounded-pill text-center m-1">
            <td><span id="regalos-entregas">0</span></td>
          </div>
        </div>  
        <!--PRIMERA TABLA DE RESUMEN-->
        <div class="row mt-5">
          <div class="col-12" style="border: 1px solid #2B39E7; height: 150px;overflow:auto;">
            <h5 class="text-center mt-2">Retiros no entregados</h5>
            <table class="" align="center">
              <tbody id="table-retiro-no-efectuado">
              </tbody>
            </table>
          </div>
          <!--SEEGUNDA TABLA DE RESUMEN-->
          <div class="col-6 mt-5 m-1" style="border: 1px solid #2B39E7; height: 250px;overflow:auto;">
            <h5 class="text-center">Retiros no efectuados</h5>
            <table class="" align="center">
              <tbody id="table-no-entregados-3">
              </tbody>
            </table>
          </div>
          <!--CONTADOR FINAL-->  
          <div class="col-5 mt-5">
            <h3 class="text-center">Resumen de Ruta</h3>
            <h3 id="os-no-entregas"></h3>
            <h3 id="piezas-no-entregas"></h3>
            <h3 id="regalos-no-entregas"></h3>
          </div>
          <!--BOTON FINAL-->  
          <div class="col-12 text-center" >
            <button class="btn btn-danger mt-3" style="border-radius: 35px" onclick=submitRecepcion()>Cerrar Ruta</button>
          </div>
        </div>
      </div>
    </div>
    <!--MODULO FINAL-->  
    <div id="end-step" class="d-none">
      <h1>Ruta Cerrada Exitosamente</h1>
    </div>
  <script src="js/recepcion.js"></script>
  </body>
<?php include('templates/footer.php');
} else {
  header('Location: index.html');
}

?>