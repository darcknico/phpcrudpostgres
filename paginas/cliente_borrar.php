
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Administrador de Clientes - Eliminar</h1>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Elminacion de Cliente
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
<?php
    $borrado=false;
    $error=false;
    $estado='';
    if (isset($_POST['cli_id'])){
        //intentó guardar
        $estado="BORRAR";
        extract($_POST);
        if ($cli_id==''){
            $error=true;
            $mensaje[]="cli_id no puede estar vacío";
        }
        if (!$error){
            include 'conexion.php'; //devuelve objeto conexion
            $query = "delete from clientes where cli_id='$cli_id';";
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

            if (!isset($cli_id) or $cli_id==''){
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
            echo "<div class='alert alert-success' role='alert'>El registro fue eliminado</div>";
            echo "<a href='?p=clientes' class='btn btn-info btn-sm' role='button'>Lista de clientes</a>";
        }else{
            if (!$error){
    ?>
            <form method="post" action="?p=cliente_borrar">
                <input type="hidden" name="cli_id" id="cli_id" value="<?=$cli_id; ?>">
                <div class="alert alert-warning" role="alert">
                    Está a punto de eliminar el cliente nro: <?=$cli_id; ?>
                </div>
                <input type="submit" class='btn btn-danger btn-sm' name="submit" value="Borrar">
                <a href='?p=clientes' class='btn btn-info btn-sm' role='button'>Cancelar</a>
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