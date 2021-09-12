<?php
session_start();
if ($_SESSION['user']['rut'] != null) {
    include('templates/header.php');
    include('templates/menu.php');
?>
    <!--PRIMERA PARTE EXCEL-->
    <div id="archivo" style="display: block;border-radius: 35px;box-shadow: 0 0px 5px 0;" class="form-row  p-5  m-5 bg-white">
        <div class=" text-center">
            <h3>Cargar Archivo</h3>
        </div>

        <div class="card-body">
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="file" onchange="validarFile(this);">
                    <label class="custom-file-label" for="file">Seleccionar Archivo</label>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-success" id="cargar" type="button">Cargar Archivos</button>
                </div>
            </div>
        </div>
    </div>
    <!--SEGUNDA PARTE EXCEL-->
    <div id="result" style="display: none;">
        <div style="display: block;border-radius: 35px;box-shadow: 0 0px 5px 0;" class="form-row  p-5  m-5 bg-white">
            <div class="col-12">
            <div class=" text-center">
            <h3>Resultados</h3>
        </div>
                <div class="card-body">
                    <!--TABLA DE DATOS DE PEDIDOS-->
                    <table class="table table-striped">
                        <tr>
                            <td>REGISTROS EN PLANILLA: </td>
                            <td id="conteo">32</td>
                        </tr>
                        <tr>
                            <td>NUEVOS PEDIDOS:</td>
                            <td id="countPedido">32</td>
                        </tr>
                        <tr>
                            <td>NUEVAS CONSULTORAS:</td>
                            <td id="countConsu">32</td>
                        </tr>
                        <tr>
                            <td>NUEVOS RETIROS:</td>
                            <td id="countRetiro">32</td>
                        </tr>
                        <tr>
                            <td>NUEVOS REGALOS:</td>
                            <td id="countBolsa">32</td>
                        </tr>
                        <tr>
                            <td>REGISTROS CON EXITO EN LA BASE DE DATOS:</td>
                            <td id="totales">32</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row text-center">
                <div class="col">
                    <button id="reset" class="btn btn-danger ">ACEPTAR</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/loadex.js"></script>
<?php include('templates/footer.php');
} else {
    header('Location: index.html');
}

?>