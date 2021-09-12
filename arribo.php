<?php
session_start();
if ($_SESSION['user']['rut'] != null) {

    include('templates/header.php');
    include('templates/menu.php');
?>
    <!--MODULO CON SOMBRA-->
    <div class="container-fluid">
        <div style="display: block;border-radius: 35px;box-shadow: 0 0px 5px 0;" class="form-row  p-5  m-5 bg-white">
            <!--TITULO-->
            <div class=" text-center">
                <h1>Arribo</h1>
            </div>
            <!--INGRESO DE CODIGO Y BOTONES-->
            <div class="col-12 input-group mb-3 mt-3">
                <input type="text" class="form-control ml-5 col-6" placeholder="Ingrese Código" style="border-radius: 35px; border-color:#2B39E7" id="codInput">
                <button class="btn btn-primary mr-3 " style="margin-left: 120px;width: 20%;
                    border-radius: 35px" type="button" id="conf">Confirmar</button>
                <button class="btn btn-warning ml-2" style="width: 20%;border-radius: 35px" type="reset">Limpiar</button>
            </div>
            <!--CONTADORES-->
            <div class=" mt-4">
                <div class="row h2">
                    <div class="col text-center ">
                        <td>OS</td>
                    </div>
                    <div class="col text-center">
                        <td>PIEZAS</td>
                    </div>
                    <div class="col text-center">
                        <td>REGALO</td>
                    </div>
                </div>
                <div class="row display-1 font-weight-bold">
                    <div class="col border border-primary rounded-pill text-center m-1">
                        <td><span id="contPcod">0</span></td>
                    </div>
                    <div class="col border border-primary rounded-pill text-center m-1 ">
                        <td><span id="contPieza">0</span></td>
                    </div>
                    <div class="col border border-primary rounded-pill text-center m-1">
                        <td><span id="contRegalo">0</span></td>
                    </div>
                </div>
            </div>
            <!--TABLAS DE PEDIDOS-->
            <div class="row">
                <div class="col" style="margin-top: 35px; height: 250px;">
                    <h5> Pedidos</h5>
                    <div class="pt-3" style="border: 1px solid #2B39E7; height: 200px;overflow:auto;">
                        <table class="table mt-4">
                            <tbody id="list">

                            </tbody>

                        </table>
                    </div>
                </div>
                <!--TABLAS DE REGALO-->
                <div class="col" style="margin-top: 35px; height: 250px;">
                    <h5>Regalos</h5>
                    <div class="pt-3" style=" border: 1px solid #2B39E7; height: 200px;overflow:auto;">
                        <table class="table mt-4 " id="listRegalo">
                        </table>
                    </div>
                </div>
            </div>

            <!--BOTON FINAL-->
            <div class=" mt-4">
                <div class="row ">
                    <div class="col text-center ">
                        <button id="guardarLista" style="border-radius: 35px;" class="btn btn-primary">GUARDAR LISTA</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/arribo.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php include('templates/footer.php');
} else {
    header('Location: index.html');
}
?>