<?php
session_start();
if ($_SESSION['user']['rut'] != null) {
    include('templates/header.php');
    include('templates/menu.php');
?>


    <body>
        <div style="display: block;border-radius: 35px;box-shadow: 0 0px 5px 0;" class="form-row  p-5  m-5 bg-white">
            <!--TITULO-->
            <div class=" text-center">
                <h1>Salida a ruta</h1>
            </div>
            <div class="row p-2">
                <div class="col p-2">
                    <form id="get-ruta" class="col-12 input-group mb-3 mt-3">
                        <input class="form-control ml-3" placeholder="Ingrese Ruta" style="border-radius: 40px; border-color:#2B39E7" type="text" id="cod-ruta" value="">
                        <button class="btn btn-primary mr-3 " style="margin-left: 120px;width: 20%;border-radius: 35px" id="conf" type="submit">Confirmar</button>
                    </form>
                </div>
                <div class="col p-2">
                    <form id="get-pedido" class="col-12 input-group mb-3 mt-3">
                        <input class="form-control ml-3" placeholder="Ingrese Código" style="border-radius: 40px; border-color:#2B39E7" type="text" id="cod-pedido" value="" disabled>
                        <button class="btn btn-primary mr-3 " style="margin-left: 120px;width: 20%;border-radius: 35px" style="width: 20%;
                    border-radius: 35px" disabled id="confirmar-codigo" >Confirmar</button>
                        <button class="btn btn-warning" style="width: 20%;
                    border-radius: 35px" id="reset-codigo" type="reset" disabled type="submit">Limpiar</button>
                    </form>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row h2">
                    <div class="col-3 text-center ">
                        <td>OS</td>
                    </div>
                    <div class="col text-center">
                        <td>PIEZAS</td>
                    </div>
                    <div class="col text-center">
                        <td>REGALO</td>
                    </div>
                    <div class="col text-center">
                        <td>RETIRO</td>
                    </div>

                </div>
                <div class="row  display-1 font-weight-bold">
                    <div class="col border border-primary rounded-pill text-center m-1">
                        <td><span id="cods">0</span></td>
                    </div>
                    <div class="col border border-primary rounded-pill text-center m-1 ">
                        <td><span id="piezas">0</span></td>
                    </div>
                    <div class="col border border-primary rounded-pill text-center m-1">
                        <td><span id="regalos">0</span></td>
                    </div>
                    <div class="col border border-primary rounded-pill text-center m-1">
                        <td><span id="retiros">0</span></td>
                    </div>
                </div>


                <div>
                    <div class="row font-weight-bold" >
                        <div class="col-6 border border-primary rounded   m-3 br-4 "style="height: 300px ;overflow:auto;" >
                            <table class="table" align="center" >
                                <tbody id="table-direcciones">
                                </tbody>
                            </table>
                        </div>

                        <div class="col border border-primary rounded m-3  " style="height: 300px ;overflow:auto;" >
                            <table class="table" align="center" >
                                <tbody id="table-regalos">
                                </tbody>
                            </table>
                        </div>
                        <div class="col border border-primary rounded m-3  " style="height: 300px ;overflow:auto;">
                            <table class="table" align="center" >
                                <tbody id="table-retiros">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center  p-2">
                        <button class="btn btn-primary" style="border-radius: 35px" id="btnSalidaRuta">Salir a ruta</button>
                    </div>
                </div>


                <script src="js/ruta.js"></script>
    </body>
<?php include('templates/footer.php');
} else {
    header('Location: index.html');
}

?>