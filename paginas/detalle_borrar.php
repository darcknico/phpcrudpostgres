

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Administrador de Facturas - Editar - Elminar Detalle</h1>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Eliminacion de un Detalle
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

    <?php
    $borrado=false;
    $error=false;
    $estado='';
    if (isset($_POST["fac_nro"]) and isset($_POST["pro_id"])){
        //intentó guardar
        $estado="BORRAR";
        extract($_POST);
        if ($fac_nro==''){
            $error=true;
            $mensaje[]="fac_nro no puede estar vacío";
        }
        if ($pro_id==''){
            $error=true;
            $mensaje[]="pro_id no puede estar vacío";
        }
        if (!$error){
            include 'conexion.php';
            $query = "delete from detfacturas where fac_nro=$fac_nro and pro_id=$pro_id";
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

            if ((!isset($fac_nro) or $fac_nro=='') or (!isset($pro_id) or $pro_id=='')){
                $error=true;
                $mensaje[]="Parámetros incompletos";
            }
            
        }       
    }
    if(isset($mensaje))
        if (is_array($mensaje)){
            echo "<div class='alert alert-warning' role='alert'>";
            foreach ($mensaje as $texto)
                echo "$texto<BR>";
            echo "</div>";
            echo "<a href='?p=factura_editar&fac_nro=$fac_nro' class='btn btn-info btn-sm' role='button'>Volver a la edicion de la factura</a>";
        }
        if (isset($borrado) and $borrado==true){
            //Ya se eliminó el registro
            echo "<div class='alert alert-success' role='alert'>El registro fue eliminado</div>";
            echo "<a href='?p=factura_editar&fac_nro=$fac_nro' class='btn btn-info btn-sm' role='button'>Volver a la edicion de la factura</a>";
        }else{
            if (!$error){
    ?>
            <form method="post" action="?p=detalle_borrar">
                <input type="hidden" name="fac_nro" id="fac_nro" value="<?=$fac_nro; ?>">
                <input type="hidden" name="pro_id" id="pro_id" value="<?=$pro_id; ?>">
                <div class="alert alert-warning" role="alert">
                    Está a punto de eliminar del detalle con el producto <?=$pro_id ?> de la factura nro: <?=$fac_nro; ?>
                </div>
                <input type="submit" class='btn btn-danger btn-sm' name="submit" value="Borrar">
                <a href='?p=factura_editar&fac_nro=$fac_nro' class='btn btn-info btn-sm' role='button'>Cancelar</a>
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