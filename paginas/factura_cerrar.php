

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Administrador de Facturas - Cerrar</h1>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Cierre de una factura
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
<?php
  $borrado=false;
  $error=false;
  $estado='';
  if (isset($_POST["fac_nro"])){
    //intentó guardar
    $estado="BORRAR";
    extract($_POST);
    if ($fac_nro==''){
      $error=true;
      $mensaje[]="fac_nro no puede estar vacío";
    }
    if (!$error){
      include 'conexion.php';
      $query = "update facturas set fac_estado='c' where fac_nro='$fac_nro'";
      if (pg_query($conexion, $query)){
        $borrado = true;
        $error=false;
      }else{
        $borrado = false;
        $mensaje[] = "Se produjo un error al borrar el registro ".pg_last_error();
        $error=true;
      }
    }
  }else{
    if (isset($_GET)){
      //viene de la grilla
      $estado="INCIAL";
      extract($_GET);

      if (!isset($fac_nro) or $fac_nro==''){
        $error=true;
        $mensaje[]="Parámetros incompletos";
      }
      
    }   
  }
    if(isset($mensaje))
    if (is_array($mensaje)){
      echo "<div class='alert alert-warning' role='alert'>";
      foreach ($mensaje as $texto)
          echo "<label class='control-label'>$texto</label><BR>";
      echo "</div>";
    }
    if (isset($borrado) and $borrado==true){
      //Ya se eliminó el registro
      echo "<div class='alert alert-success' role='alert'>El registro fue cambiado</div>";
      echo "<a href='?p=facturas' class='btn btn-info btn-sm' role='button'>Lista de facturas</a>";
    }else{
      if (!$error){
  ?>
      <form method="post" action="?p=factura_cerrar">
        <input type="hidden" name="fac_nro" id="fac_nro" value="<?=$fac_nro; ?>">
        <div class="alert alert-warning" role="alert">
          Está a punto de cerrar la factura nro: <?=$fac_nro; ?>
        </div>
        <input type="submit" class='btn btn-danger btn-sm' name="submit" value="Cerrar">
        <a href='?p=facturas' class='btn btn-info btn-sm' role='button'>Cancelar</a>
      </form> 
  <?php 
    }
  }
  ?>


                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
