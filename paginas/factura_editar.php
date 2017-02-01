

    <script src="js/jquery-3.1.1.min.js" type="text/javascript"> </script>
    <script src="js/bootstrap.min.js" type="text/javascript"> </script>

    <script type="text/javascript" src="js/moment.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="js/transition.js"></script>
    <script type="text/javascript" src="js/collapse.js"></script>


        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Administrador de Facturas - Editar</h1>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Edicion de la factura
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
    <?php

    include 'conexion.php'; //devuelve objeto conexion

    $guardado=false;
    $error=false;
    if (isset($_POST['submit'])){
        //intentó guardar
        extract($_POST);
        if (!isset($fac_fecha) or $fac_fecha==''){
            $error=true;
            $mensaje[]="La fecha no puede estar vacío";
        }
        if (!isset($fac_formapago) or $fac_formapago==''){
            $error=true;
            $mensaje[]=" La forma de pago no puede estar vacío";
        }
      if (!isset($cli_id) or $cli_id==''){
        $error=true;
        $mensaje[]="El cliente no puede estar vacio";
      }
        if (!$error){
            $query = "update facturas set fac_fecha='$fac_fecha',fac_formapago='$fac_formapago', cli_id=$cli_id";
            if (pg_query($conexion, $query)){
                $guardado = true;
                $mensaje[]="La factura se guardó correctamente";
                $error=false;
            }else{
                $guardado = false;
                $mensaje[] = "Se produjo un error al guardar el registro ".pg_last_error();
                $error=true;
            }
        }
    }
    if(isset($mensaje))
        if (is_array($mensaje)){
            foreach ($mensaje as $texto)
                echo "$texto<BR>";          
        }
        if (isset($guardado) and $guardado==true){
            //Ya se guardó el registro
            echo "<a href='?p=facturas' class='btn btn-info btn-sm' role='button'>Lista de facturas</a>";
        }else{

        if (isset($_GET)){
          $estado="INCIAL";
          extract($_GET);
        }
        if (isset($_POST['submit'])){
          extract($_POST);
        }
        if (!isset($fac_nro) or $fac_nro==''){
          $error=true;
          $mensaje[]="Parámetros incompletos";
        } else {
          $query = "SELECT fac_nro,fac_fecha,fac_formapago,cli_id FROM facturas where fac_nro=$fac_nro";
          $result = pg_query($conexion, $query);
          $rowCount = pg_num_rows($result);
          if($rowCount>0){
            $row = pg_fetch_array($result);
            $fac_nro = $row[0];
            $fac_fecha = $row[1];
            $fac_formapago = $row[2];
            $cli_id2=$row[3];
          }
        }
     ?>

      

      <input type="hidden" name="fac_nro" id="fac_nro" value="<?=$fac_nro; ?>">

       <div class="form-group">
        <label class="control-label requiredField" for="fac_fecha">
         Fecha
         <span class="asteriskField">
          *
         </span>
        </label>
        <div class='input-group date' id='fechorapicker'>
          <input class="form-control" id="fac_fecha" name="fac_fecha" placeholder="fecha" type="text" value="<?=$fac_fecha; ?>" readonly />
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
       </div>

       <div class="form-group">
        <label class="control-label requiredField" for="fac_formapago">
         Forma de pago
         <span class="asteriskField">
          *
         </span>
        </label>
        <input class="form-control" id="fac_formapago" name="fac_formapago" placeholder="Forma de pago" type="text" value="<?=$fac_formapago; ?>" readonly />
       </div>

      <?php

        $query = "SELECT cli_id,cli_apellido, cli_nombre FROM clientes ORDER BY 2 ASC";
        $result = pg_query($conexion, $query);
        $rowCount = pg_num_rows($result);
        ?>
        <div class="form-group">
          <label class="control-label requiredField" for="fac_formapago">
             Cliente
             <span class="asteriskField">
              *
             </span>
          </label>
                <select name="cli_id" id="cli_id" class="selectpicker form-control" data-live-search="true" disabled>
                    <option disabled>Seleccione el Cliente</option>
                    <?php
                    
                    if($rowCount > 0){
                        while($row = pg_fetch_row($result)){
                if($row[0] == $cli_id2) {
                  echo "<option value='$row[0]' selected >$row[1] $row[2]</option>";
                } else
                              echo "<option value='$row[0]'>$row[1] $row[2]</option>";
                        }
                    }else{
                        echo '<option disable>Cliente no habilitado</option>';
                    }
                    ?>
                </select>
        </div>

        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Lista de Detalles
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

        <a href='?p=detalle_nuevo&fac_nro=<?=$fac_nro; ?>' class='btn btn-success btn-sm' role='button'><span class='glyphicon glyphicon-plus'></span> Nuevo Detalle</a></small>
        
          <?php
          $query = "SELECT pro_id,pro_descripcion,mar_descripcion,df_cant,df_preciounit,df_cant*df_preciounit as subtotal ".
          " FROM detfacturas INNER JOIN productos using(pro_id) INNER JOIN marcas using(mar_id) WHERE fac_nro=$fac_nro";

          $resultado = pg_query($conexion, $query) or die("Error en la Consulta SQL".pg_last_error());
          $numReg = pg_num_rows($resultado);

          if($numReg>0){
            echo "<table width='100%' class='table table-striped table-bordered table-hover' id='tablaDetalle'>
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Cantidad</th>
                <th>P/U</th>
                <th>Subtotal</th>
                <th>Acciones</th></tr></thead><tbody>";
                while ($fila=pg_fetch_array($resultado)) {
                  echo "<tr>";
                  echo "<td>$fila[pro_descripcion]</td>";
                  echo "<td>$fila[mar_descripcion]</td>";
                  echo "<td>$fila[df_cant]</td>";
                  echo "<td>$fila[df_preciounit]</td>";
                  echo "<td>$fila[subtotal]</td>";
                  echo "<td>
                  <a href='?p=detalle_borrar&fac_nro=$fac_nro&pro_id={$fila['pro_id']}' class='btn btn-default btn-xs' role='button'><span class='glyphicon glyphicon-remove'></span></a>
                </td>";
                echo "</tr>";
              }
              echo "</tbody></table>";

              $query = "SELECT sum(df_cant*df_preciounit) as total FROM detfacturas WHERE fac_nro=$fac_nro GROUP BY fac_nro";
              $numReg = pg_num_rows($resultado);
              if($numReg>0){
                $fila=pg_fetch_array($resultado);
              ?>
        <div class="form-group">
            <label class="control-label requiredField" for="fac_formapago">
             Total de la FACTURA
            </label>
            <div class="input-group">
                <span class="input-group-addon">$</span>
                <input class="form-control" id="fac_formapago" name="fac_formapago" type="text" value="<?=$fila['total']; ?>" readonly />
            </div>
        </div>

            <?php
                }

            }else{
              echo "<label class='control-label'>No hay Registros</label>";
            }

            ?>

      <script type="text/javascript">
            $(document).ready(function() {
              $("#fechorapicker").datepicker('setDate', $(this).val());

              $(function () {
                $('#fechorapicker').datetimepicker({
                  format:'DD/MM/YYYY'
                })
              });
            });
        </script>

      <?php 
    }
    ?>
                    </div>
                </div>
            </div>
        </div>
    <a href='?p=facturas' class='btn btn-info btn-sm' role='button'>Lista de facturas</a>

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

        <!-- DataTables JavaScript -->
    <script src="datatables/js/jquery.dataTables.min.js"></script>
    <script src="datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="datatables-responsive/dataTables.responsive.js"></script>

    <script>
    $(document).ready(function() {
        $('#tablaDetalle').DataTable({
            responsive: true
        });
    });
    </script>