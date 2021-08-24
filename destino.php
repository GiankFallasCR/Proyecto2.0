<?php
include './library/configServer.php';
include './library/consulSQL.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Destinos</title>
    <?php include './inc/link.php'; ?>
</head>
<body id="container-page-destino">
    <?php include './inc/navbar.php'; ?>
    <section id="store">
       <br>
        <div class="container">
            <div class="page-header">
              <h1>Destinos <small class="tittles-pages-logo">Viajitico</small></h1>
            </div>
              <div class="container-fluid">
                <div class="row">
                  
                  <div class="col-xs-12 col-md-4 col-md-offset-4">
                    <form action="./search.php" method="GET">
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                          <input type="text" id="addon1" class="form-control" name="term" required="" title="Escriba nombre o Provincia del destino">
                          <span class="input-group-btn">
                              <button class="btn btn-info btn-raised" type="submit">Buscar</button>
                          </span>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <div class="row">
                <?php
                  $mysqli = mysqli_connect(SERVER, USER, PASS, BD);
                  mysqli_set_charset($mysqli, "utf8");

                  $pagina = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;
                  $regpagina = 20;
                  $inicio = ($pagina > 1) ? (($pagina * $regpagina) - $regpagina) : 0;

                  $consultar_destinos=mysqli_query($mysqli,"SELECT SQL_CALC_FOUND_ROWS * FROM destino WHERE cantidad > 0 AND Estado='Activo' LIMIT $inicio, $regpagina");

                  $totalregistros = mysqli_query($mysqli,"SELECT FOUND_ROWS()");
                  $totalregistros = mysqli_fetch_array($totalregistros, MYSQLI_ASSOC);
        
                  $numeropaginas = ceil($totalregistros["FOUND_ROWS()"]/$regpagina);

                ?>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                         <div class="thumbnail">
                           <img class="img-destino" src="./assets/img-destinos/<?php if($destino['Imagen']!="" && is_file("./assets/img-destinos/".$destino['Imagen'])){ echo $destino['Imagen']; }else{ echo "default.png"; } ?>
                           ">
                           <div class="caption">
                             <h3><?php echo $destino['Provincia']; ?></h3>
                             <p><?php echo $destino['NombreDestino']; ?></p>
                             <?php if($destino['Descuento']>0): ?>
                             <p>
                             <?php
                             $pref=number_format($destino['Precio']-($destino['Precio']*($destino['Descuento']/100)), 2, '.', '');
                             echo $destino['Descuento']."% descuento: $".$pref; 
                             ?>
                             </p>
                             <?php else: ?>
                              <p>$<?php echo $destino['Precio']; ?></p>
                             <?php endif; ?>
                             <p class="text-center">
                                 <a href="infoProd.php?CodigoDestino=<?php echo $destino['CodigoDestino']; ?>" class="btn btn-primary btn-raised btn-sm btn-block"><i class="fa fa-plus"></i>&nbsp; Detalles</a>
                             </p>

                           </div>
                         </div>
                     </div>     
\
                <div class="clearfix"></div>
                <div class="text-center">
                  <ul class="pagination">
                    <?php if($pagina == 1): ?>
                        <li class="disabled">
                            <a>
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    

                    <?php if($pagina == $numeropaginas): ?>
                        <li class="disabled">
                            <a>
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                  </ul>
                </div>

        </div>
    </section>
    <?php include './inc/footer.php'; ?>
</body>
</html>