        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Administrador de Clientes</h1>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Lista de Clientes
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <a href="?p=cliente_nuevo" class='btn btn-success btn-sm' role='button'><span class='glyphicon glyphicon-user'></span> Nuevo Cliente</a>

    <?php
    include 'conexion.php'; //devuelve objeto conexion
    $query = "SELECT cli_id, cli_apellido, cli_nombre, cli_domicilio, ciu_nombre FROM clientes INNER JOIN ciudades using(ciu_id) ORDER BY 1;";

    $resultado = pg_query($conexion, $query) or die("Error en la Consulta SQL".pg_last_error());
    $numReg = pg_num_rows($resultado);

    if($numReg>0){
        echo "<table width='100%' class='table table-striped table-bordered table-hover' id='tabla'>
        <thead>
        <tr>
        <th>ID</th>
        <th>Apellido</th>
        <th>Nombre</th>
        <th>Domicilio</th>
        <th>Ciudad</th>
        <th>Acciones</th></tr></thead><tbody>";
        while ($fila=pg_fetch_array($resultado)) {
            echo "<tr>";
            echo "<td>$fila[cli_id]</td>";
            echo "<td>$fila[cli_apellido]</td>";
            echo "<td>$fila[cli_nombre]</td>";
            echo "<td>$fila[cli_domicilio]</td>";
            echo "<td>$fila[ciu_nombre]</td>";
            echo "<td>
                <a href='?p=cliente_editar&cli_id={$fila['cli_id']}' class='btn btn-default btn-xs' role='button'><span class='glyphicon glyphicon-pencil'></span></a>
                <a href='?p=cliente_borrar&cli_id={$fila['cli_id']}' class='btn btn-default btn-xs' role='button'><span class='glyphicon glyphicon-remove'></span></a>
                </td>";
            echo "</tr>";
        }
        echo "</thead></table>";
        echo "";
    }else{
        echo "<label class='control-label'>No hay Registros</label>";
    }

    pg_close($conexion);

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

    </div>
    <!-- /#wrapper -->


    <script>
    $(document).ready(function() {
        $('#tabla').DataTable({
            responsive: true
        });
    });
    </script>

     <!-- DataTables JavaScript -->
    <script src="datatables/js/jquery.dataTables.min.js"></script>
    <script src="datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="datatables-responsive/dataTables.responsive.js"></script>
