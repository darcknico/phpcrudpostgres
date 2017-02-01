
    <script type="text/javascript" src="js/moment.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="js/transition.js"></script>
    <script type="text/javascript" src="js/collapse.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.0/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.0/js/bootstrap-select.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.0/js/i18n/defaults-*.min.js"></script>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Administrador de Productos - Agregar</h1>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Campos para un nuevo producto
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
        if (!isset($pro_descripcion) or $pro_descripcion==''){
            $error=true;
            $mensaje[]="La descripcion no puede estar vacío";
        }
        if (!isset($pro_precio) or $pro_precio==''){
            $error=true;
            $mensaje[]=" El precio no puede estar vacío";
        }
    if (!isset($pro_stock) or $pro_stock==''){
      $error=true;
      $mensaje[]=" El stock no puede estar vacío";
    }

    if (!isset($mar_id) or $mar_id==''){
      $error=true;
      $mensaje[]=" mar_id no puede estar vacío";
    }
        if (!$error){
            $query = "insert into productos(pro_precio, pro_stock, pro_descripcion,mar_id) values('$pro_precio','$pro_stock','$pro_descripcion',$mar_id);";
            if (pg_query($conexion, $query)){
                $guardado = true;
                $mensaje[]="El producto se guardó correctamente";
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
                echo "<label class='control-label'>$texto</label><BR>";          
        }
        if (isset($guardado) and $guardado==true){
            //Ya se guardó el registro
            echo "<a href='?p=productos' class='btn btn-info btn-sm' role='button'>Lista de productos</a>";
        }else{
     ?>
    <form method="post">
     
         <div class="form-group">
          <label class="control-label requiredField" for="pro_descripcion">
           Descripcion
           <span class="asteriskField">
            *
           </span>
          </label>
          <input class="form-control" id="pro_descripcion" name="pro_descripcion" placeholder="Descripcion" type="text" value=""/>
          <span class="help-block" id="hint_">
           Ingrese su descripcion 
          </span>
         </div>

         <div class="form-group">
          <label class="control-label requiredField" for="pro_precio">
           Precio
           <span class="asteriskField">
            *
           </span>
          </label>
          <div class="input-group">
            <span class="input-group-addon">$</span>
          <input class="form-control" id="pro_precio" name="pro_precio" placeholder="Precio" type="text" value=""/>
          </div>
          <span class="help-block" id="hint_email">
           Ingrese su precio
          </span>
         </div>

         <div class="form-group">
          <label class="control-label requiredField" id="pro_stock" name="pro_stock" placeholder="Stock" for="pro_stock">
           Stock
           <span class="asteriskField">
            *
           </span>
          </label>
          <input class="form-control" id="pro_stock" name="pro_stock" type="text" value=""/>
          <span class="help-block" id="hint_subject">
           Ingrese stock
          </span>
         </div>

        <?php
        $query = "SELECT mar_id,mar_descripcion FROM marcas ORDER BY 2 ASC";
          $result = pg_query($conexion, $query);
          $rowCount = pg_num_rows($result);
          ?>
            <div class="form-group">
              <label class="control-label requiredField" for="fac_formapago">
                 Marca
                 <span class="asteriskField">
                  *
                 </span>
              </label>
              <select name="mar_id" id="mar_id" class="selectpicker form-control" data-live-search="true">
                <option readonly>Seleccione la marca</option>
                <?php
                
                if($rowCount > 0){
                  while($row = pg_fetch_row($result)){
                      echo "<option value='$row[0]'>$row[1]</option>";
                  }
                }else{
                  echo '<option disabled>Marcas no habilitado</option>';
                }
                ?>
              </select>
            </div>

           <button class="btn btn-primary " name="submit" type="submit">
            Guardar
           </button>


    </form>
    <?php  
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