<?php
session_start();
if ($_SESSION['user']['rut'] != null) {
    include('templates/header.php');
    include('templates/menu.php');
?>
    <!--PRIMERA PARTE-->
    <div class="container-fluid">
        <div style="display: block;border-radius: 35px;box-shadow: 0 0px 5px 0;" class="form-row  p-5  m-5 bg-white" id="vista1">
            <!--TITULO -->
            <div class=" text-center">
                <h1>Asociación</h1>
            </div>
            <!--INGRESO DE CODIGO Y BOTONES-->
            <div class="col-12 input-group mb-3 mt-3">
                <input type="text" class="form-control ml-5" placeholder="Ingrese Código" style="border-radius: 40px; border-color:#2B39E7" id="codInput">
                <button class="btn btn-primary mr-3 " style="margin-left: 120px;width: 20%;border-radius: 35px" type="button" id="conf">Confirmar</button>
                <button class="btn btn-warning ml-2" style="width: 20%;border-radius: 35px" type="reset">Limpiar</button>
            </div>
            <!--TABLA -->
            <div class="mt-5">
                <h3 class="col">Lista de pedidos</h3>
                <div class="col mt-2" style="border: 1px solid #2B39E7; border-radius: 35px; height: 350px;overflow:auto;">
                    <ol class="list-group list-group-numbered mt-3 m-1 ">
                        <div class="row" id="lista">
                        </div>
                    </ol>
                </div>
            </div>
            <div class="col text-center mt-4">
                <button class="btn btn-primary" style="border-radius: 35px" id="posicion">Asociar Lista</button>
            </div>
        </div>
    </div>
    <!--SEGUNDA PARTE-->
    <div id="busqueda" style="display: none;">
        <div class="container-fluid">
            <div style="display: block;border-radius: 35px;box-shadow: 0 0px 5px 0;" class="form-row  p-5  m-5 bg-white">
                <div class=" text-center">
                    <h1>Asociación</h1>
                </div>
                <div class="col-12">
                    <div class="col-12 input-group mb-3 mt-3">
                        <input type="text" class="form-control ml-5" placeholder="Ingrese Código" style="border-radius: 40px; border-color:#2B39E7" type="text" id="codInput2" value="">
                        <button class="btn btn-primary mr-3 " style="margin-left: 120px;width: 20%;border-radius: 35px" id="confPedido">Confirmar</button>
                        <button class="btn btn-warning ml-2" style="width: 20%;border-radius: 35px" type="reset">Limpiar</button>
                    </div>
                </div>
                <div style="margin-top: 20px;text-align: center;">
                    <div class="container-fluid" style="margin-top: 20px;text-align: center;">
                        <div class="h2">
                            <div class=" text-center">
                                <h1 id="posicionh1" >Ingresa los códigos de tu lista</h1>
                            </div>
                        </div>
                        <div class="row justify-content-center  display-1 font-weight-bold ">
                            <div class=" col-3 border border-primary rounded-pill m-1">
                                <td><span id="cod2"></span></td>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col text-center ">
                    <button class="btn btn-danger mt-3" style="border-radius: 35px" id="fin" >Termiar Lista</button>
                </div>
            </div>
        </div>
    </div>
    <script src="js/asociacion.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php include('templates/footer.php');
} else {
    header('Location: index.html');
}

?>