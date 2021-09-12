<?php
session_start();
if($_SESSION ['user']['rut']!=null){
include('templates/header.php');  
include('templates/menu.php');
?>

<!--CONTAINER BIENVENIDA-->
<!--CONTAINER BIENVENIDA-->
<!--CONTAINER BIENVENIDA-->
<!--CONTAINER BIENVENIDA-->
<!--CONTAINER BIENVENIDA-->
<div class="container">
    <div class="row">
        <div class="card mt-5 col-12 bg-white m-4 " style="padding: 30px; border-radius: 15px; box-shadow: 0 0px 5px 0;">
            <!--DATOS DEL PERFIL-->
            <h1 class="card-title mt-3"> <?php echo 'Perfil de '.$_SESSION ['user']['perfil']; ?> </h3>
            <div class="card"></div>
            <h5 class="card-title"> <?php echo 'Nombre: '.$_SESSION ['user']['fullname']; ?> </h5>
            <h5 class="card-title"> <?php echo 'Correo: '.$_SESSION ['user']['correo']; ?> </h5>
            <h5 class="card-title"> <?php echo 'RUT: '.$_SESSION ['user']['rut']; ?> </h5>
            </div>
        </div>
    </div>
</div>

<?php include('templates/footer.php'); 
}else{
   header('Location: index.html'); 
}
?>