<?php
session_start();
if($_SESSION ['user']['rut']!=null){
include('templates/header.php');
include('templates/menu.php');
?>

<div class="container-fluid">
    <div class="row offset-1 mt-5" style="margin-right: 130px; border-radius:35px; 
             box-shadow: 0 0px 10px 0;"> 
                            <div class="col center" id="busqueda">
                                <input type="text" class="control" id="btnIdRuta" placeholder="Ingrese Ruta" value="" >
                                <button class="btn btn-primary" id="btnRuta">Confirmar</button>
                                <button class="btn btn-warning" type="reset">Limpiar</button>
                                <input type="text" class="control" id="" placeholder="Ingrese Codigo" value="" >
                                <button class="btn btn-primary" id="">Confirmar</button>
                                <button class="btn btn-warning" type="">Limpiar</button>            
                            </div>
                        </div>





                    <div id="consultoraVista" style="display : none;">
                    <!--TABLA DE PEDIDOS-->

                    <table class="table-light">
                            <tr class="table-light">    
                                <td class="table-light">
                                    <ul id="lista"></ul>
                                </td>
                            </tr>
                        </table>

                        <button class="btn btn-primary" id="consultoraVista">Avanzar</button>  
                    </div>
                    </div>
</div>
<script src="js/recepcion.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php include('templates/footer.php'); 
}else{
    header('Location: index.html'); 
 }

?>