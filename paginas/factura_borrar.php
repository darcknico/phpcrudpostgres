        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Administrador de Facturas - Eliminar</h1>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Eliminando una Factura
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
            $query = "delete from facturas where fac_nro='$fac_nro'";
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
            echo "<a href='?p=facturas' class='btn btn-info btn-sm' role='button'>Lista de facturas</a>";
        }
        if (isset($borrado) and $borrado==true){
            //Ya se eliminó el registro
            echo "<div class='alert alert-success' role='alert'>El registro fue eliminado</div>";
            echo "<a href='?p=facturas' class='btn btn-info btn-sm' role='button'>Lista de facturas</a>";
        }else{
            if (!$error){
    ?>
            <form method="post" action="?p=factura_borrar">
                <div class="form-group">
                    <input type="hidden" name="fac_nro" id="fac_nro" value="<?=$fac_nro; ?>">
                    <div class="alert alert-warning" role="alert">
                        Está a punto de eliminar la factura nro: <?=$fac_nro; ?>
                    </div>
                    <input type="submit" class='btn btn-danger btn-sm' name="submit" value="Borrar">
                    <a href='?p=facturas' class='btn btn-info btn-sm' role='button'>Cancelar</a>
                </div>
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