

load = document.getElementById('cargar');
file = document.getElementById('file');
form = document.getElementById('form');
result = document.getElementById('result');
archivo = document.getElementById('archivo');
reset = document.getElementById('reset');






function validarFile(all) {
    //EXTENSIONES Y TAMANO PERMITIDO.
    var extensiones_permitidas = [".xlsx"];
    var rutayarchivo = all.value;
    var ultimo_punto = all.value.lastIndexOf(".");
    var extension = rutayarchivo.slice(ultimo_punto, rutayarchivo.length);

    if (extensiones_permitidas.indexOf(extension) == -1) {
        alert("PORFAVOR INGRESE UN ARCHIVO EXCEL");
        document.getElementById(all.id).value = "";
        return;
    }
}

function cargardatos() {

    if (file.value != "") {
        var filee = file.files[0];

        var datos = new FormData();
        datos.append('file', filee);

        $.ajax({
            type: 'POST',
            url: ('recursos/funciones/loadex_fx.php'),
            cache: false,
            contentType: false,
            processData: false,
            data: datos,
            datatype: { JSON },
            success: function (data) {
                let resp = JSON.parse(data);
                if (resp['existe']) {
                    archivo.style.display = "none";
                    result.style.display = "block";
                    document.getElementById('conteo').textContent=resp['conteo'];
                    document.getElementById('countPedido').textContent=resp['countPedido'];
                    document.getElementById('countConsu').textContent=resp['countConsu'];
                    document.getElementById('countRetiro').textContent=resp['countRetiro'];
                    document.getElementById('countBolsa').textContent=resp['countBolsa'];
                    document.getElementById('totales').textContent=resp['totales'];
                } else {
                    alert("EL ARCHIVO SELECCIONADO NO COINCIDE CON EL FORMATO");
                    document.getElementById(file.id).value = "";
                }
            },
        });
    } else {
        alert("SELECCIONA UN ARCHIVO ANTES DE CONTINUAR");
    }

}



load.addEventListener('click', cargardatos);
reset.addEventListener('click', function reset() {
    location.reload();
});
