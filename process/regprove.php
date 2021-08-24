<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';

$CedulaProve=consultasSQL::clean_string($_POST['prove-Cedula']);
$nameProve=consultasSQL::clean_string($_POST['prove-name']);
$dirProve=consultasSQL::clean_string($_POST['prove-dir']);
$telProve=consultasSQL::clean_string($_POST['prove-tel']);
$webProve=consultasSQL::clean_string($_POST['prove-web']);

$verificar=  ejecutarSQL::consultar("SELECT * FROM proveedor WHERE CedulaProveedor='".$CedulaProve."'");
if(mysqli_num_rows($verificar)<=0){
    if(consultasSQL::InsertSQL("proveedor", "CedulaProveedor, NombreProveedor, Direccion, Telefono, PaginaWeb", "'$CedulaProve','$nameProve','$dirProve','$telProve','$webProve'")){
        echo '<script>
            swal({
              title: "Proveedor registrado",
              text: "Los datos del proveedor se agregaron con éxito",
              type: "success",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Aceptar",
              cancelButtonText: "Cancelar",
              closeOnConfirm: false,
              closeOnCancel: false
              },
              function(isConfirm) {
              if (isConfirm) {
                location.reload();
              } else {
                location.reload();
              }
            });
        </script>';
    }else{
       echo '<script>swal("ERROR", "Ocurrió un error inesperado, por favor intente nuevamente", "error");</script>';
    }
}else{
    echo '<script>swal("ERROR", "El número de Cedula/CEDULA que ha ingresado ya se encuentra registrado en el sistema, por favor ingrese otro número de Cedula o CEDULA", "error");</script>';
}
mysqli_free_result($verificar);