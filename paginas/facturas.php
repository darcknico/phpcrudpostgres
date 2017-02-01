
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Administrador de Facturas</h1>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Lista de Facturas
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <a href='?p=factura_nuevo' class='btn btn-success btn-sm' role='button'><span class='glyphicon glyphicon-plus'></span> Nueva Factura</a>
                            
                            <?php
    include 'conexion.php'; //devuelve objeto conexion
    $query = "SELECT * FROM facturas INNER JOIN clientes using(cli_id) ORDER BY 1";

    $resultado = pg_query($conexion, $query) or die("Error en la Consulta SQL".pg_last_error());
    $numReg = pg_num_rows($resultado);

    if($numReg>0){
        echo "<table width='100%'' class='table table-striped table-bordered table-hover' id='tablaFacturas'>
        <thead>
        <tr>
        <th>ID</th>
        <th>Fecha</th>
        <th>Forma de Pago</th>
        <th>Estado</th>
        <th>Cliente</th>
        <th>Acciones</th></tr></thead><tbody>";
        while ($fila=pg_fetch_array($resultado)) {
            echo "<tr>";
            echo "<td>$fila[fac_nro]</td>";
            echo "<td>$fila[fac_fecha]</td>";
            echo "<td>$fila[fac_formapago]</td>";
            echo "<td>$fila[fac_estado]</td>";
            echo "<td>$fila[cli_apellido] $fila[cli_nombre]</td>";
            echo "<td>
                <a href='?p=factura_editar&fac_nro={$fila['fac_nro']}' class='btn btn-default btn-xs' role='button'><span class='glyphicon glyphicon-pencil'></span></a>
                <a href='?p=factura_borrar&fac_nro={$fila['fac_nro']}' class='btn btn-default btn-xs' role='button'><span class='glyphicon glyphicon-remove'></span></a>
                <a href='?p=factura_cerrar&fac_nro={$fila['fac_nro']}' class='btn btn-default btn-xs' role='button'><span class='glyphicon glyphicon glyphicon-ok'></span></a>
                </td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
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

    <script>
    $(document).ready(function() {
        $('#tablaFacturas').DataTable({
            responsive: true
        });
    });
    </script>

    <!-- DataTables JavaScript -->
    <script src="datatables/js/jquery.dataTables.min.js"></script>
    <script src="datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="datatables-responsive/dataTables.responsive.js"></script>
