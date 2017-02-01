
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Administrador de Productos</h1>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Lista de Productos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="nav">
                                <a href='?p=producto_nuevo' class='btn btn-success btn-sm' role='button'><span class='glyphicon glyphicon-plus'></span> Nuevo Producto</a>
                            </ul>
    <?php
    include 'conexion.php'; //devuelve objeto conexion

    $query = "SELECT * FROM productos INNER JOIN marcas using(mar_id)";

    $resultado = pg_query($conexion, $query) or die("Error en la Consulta SQL".pg_last_error());
    $numReg = pg_num_rows($resultado);

    if($numReg>0){
        echo "<table width='100%'' class='table table-striped table-bordered table-hover' id='tablaProductos'>
        <thead>
        <tr>
        <th>ID</th>
        <th>DESCRIPCION</th>
        <th>STOCK</th>
        <th>PRECIO</th>
        <th>MARCA</th>
        <th>Acciones</th></tr></thead><tbody>";
        while ($fila=pg_fetch_array($resultado)) {
            echo "<tr>";
            echo "<td>$fila[pro_id]</td>";
            echo "<td>$fila[pro_descripcion]</td>";
            echo "<td>$fila[pro_stock]</td>";
            echo "<td>$fila[pro_precio]</td>";
            echo "<td>$fila[mar_descripcion]</td>";
            echo "<td>
                <a href='?p=producto_editar&pro_id={$fila['pro_id']}' class='btn btn-default btn-xs' role='button'><span class='glyphicon glyphicon-pencil'></span></a>
                <a href='?p=producto_borrar&pro_id={$fila['pro_id']}' class='btn btn-default btn-xs' role='button'><span class='glyphicon glyphicon-remove'></span></a>
                </td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
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
        $('#tablaProductos').DataTable({
            responsive: true
        });
    });
    </script>

    <!-- DataTables JavaScript -->
    <script src="datatables/js/jquery.dataTables.min.js"></script>
    <script src="datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="datatables-responsive/dataTables.responsive.js"></script>
