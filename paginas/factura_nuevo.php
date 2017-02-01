

    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" />
    <script type="text/javascript" src="js/moment.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="js/transition.js"></script>
    <script type="text/javascript" src="js/collapse.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.0/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.0/js/bootstrap-select.min.js" type="text/javascript"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.0/js/i18n/defaults-*.min.js" type="text/javascript"></script>


        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Administrador de Facturas - Agregar</h1>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Campos para una nueva Factura
                        </div>
                        <!-- /.panel-heading -->
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
            $query = "insert into facturas(fac_fecha,fac_formapago,cli_id) values(to_date('$fac_fecha','dd/mm/yyyy'),'$fac_formapago',$cli_id);";
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
            echo "<a href='?p=facturas' class='btn btn-info btn-sm' role='button'>Facturas</a>";
        }else{
     ?>


      <form method="post">
       
      <div class="form-group">
        <label class="control-label requiredField" for="fac_fecha">
         Fecha
         <span class="asteriskField">
          *
         </span>
        </label>
        <div class='input-group date' id='fechorapicker'>
          <input class="form-control" id="fac_fecha" name="fac_fecha" placeholder="Fecha de la factura" type="text"/>
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
        <span class="help-block" id="hint_">
        Ingrese fecha   
       </span>
      </div>

      <div class="form-group">
        <label class="control-label requiredField" for="fac_formapago">
         Forma de pago
         <span class="asteriskField">
          *
         </span>
        </label>
        <input class="form-control" id="fac_formapago" name="fac_formapago" placeholder="Forma de pago" type="text"/>
        <span class="help-block" id="hint_email">
         Ingrese la forma de pago
        </span>
      </div>

      <?php

        $query = "SELECT cli_id , cli_nombre,cli_apellido FROM clientes ORDER BY 2 ASC";
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
            <select name="cli_id" id="cli_id" class="selectpicker form-control" data-live-search="true">
                <option value="">Seleccione el Cliente</option>
                <?php
                
                if($rowCount > 0)
            {
                    while($row = pg_fetch_row($result)){ 
                        echo "<option value='$row[0]'>$row[2], $row[1]</option>";
                    }
                }else{
                    echo '<option value="">Cliente no habilitado</option>';
                }
        
                ?>
            </select>
        </div>

        <button class="btn btn-primary" name="submit" type="submit">
         Guardar
        </button>


        

        </form>

      <script type="text/javascript">
            $(function () {
                $('#fechorapicker').datetimepicker({
                  format:'DD/MM/YYYY'
                });
            });
        </script>
        
      <?php 
    }
    ?>

                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->