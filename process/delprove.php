<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';

$CedulaProve=consultasSQL::clean_string($_POST['Cedula-prove']);
$cons=ejecutarSQL::consultar("SELECT * FROM destino WHERE CedulaProveedor='$CedulaProve'");
if(mysqli_num_rows($cons)<=0){
    if(consultasSQL::DeleteSQL('proveedor', "CedulaProveedor='".$CedulaProve."'")){
        echo '<script>
		    swal({
		      title: "Proveedor eliminado",
		      text: "Los datos del proveedor se eliminaron exitosamente",
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
    echo '<script>swal("ERROR", "Lo sentimos no podemos eliminar el proveedor ya que existen destinos asociados a este proveedor", "error");</script>';
}
mysqli_free_result($cons);