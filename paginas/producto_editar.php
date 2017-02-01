

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
                        Administrador de Productos - Editar</h1>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Edicion de un producto
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
      $mensaje[]="pro_descripcion no puede estar vacío";
    }
    if (!isset($pro_precio) or $pro_precio==''){
      $error=true;
      $mensaje[]=" pro_precio no puede estar vacío";
    }
    if (!isset($pro_stock) or $pro_stock==''){
      $error=true;
      $mensaje[]=" pro_stock no puede estar vacío";
    }
    if (!isset($marca) or $marca==''){
      $error=true;
      $mensaje[]=" la marca no puede estar vacío";
    }
    if (!$error){
      $query = "update productos set pro_descripcion='$pro_descripcion',pro_precio='$pro_precio',pro_stock='$pro_stock',mar_id=$marca where pro_id=$pro_id ";
      if (pg_query($conexion, $query)){
        $guardado = true;
        $mensaje[]="El producto se modifco correctamente";
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

        if (isset($_GET)){
          $estado="INCIAL";
          extract($_GET);
        }
        if (isset($_POST['submit'])){
          extract($_POST);
        }
        if (!isset($pro_id) or $pro_id==''){
          $error=true;
          $mensaje[]="Parámetros incompletos";
        } 
        else 
        {

          $query1 = "SELECT pro_descripcion,pro_precio,pro_stock,mar_id FROM productos INNER JOIN marcas using(mar_id) where pro_id=$pro_id";
          $result1 = pg_query($conexion, $query1);
          $rowCount = pg_num_rows($result1);
          if($rowCount>0){
            $row = pg_fetch_array($result1);
            $pro_descripcion = $row[0];
            $pro_precio = $row[1];
            $pro_stock = $row[2];
            $mar_id2 = $row[3];
          }
        }
     ?>

    <form method="post">

    <input type="hidden" name="pro_id" id="pro_id" value="<?=$pro_id; ?>">
     
     <div class="form-group">
      <label class="control-label requiredField" for="pro_descripcion">
       Descripcion
       <span class="asteriskField">
        *
       </span>
      </label>
      <input class="form-control" id="pro_descripcion" name="pro_descripcion" type="text" value="<?=$pro_descripcion; ?>"/>
      <span class="help-block" id="hint_">
       Ingrese la descripcion   
      </span>
     </div>

     <div class="form-group">
      <label class="control-label requiredField" for="pro_precio">
       Precio
       <span class="asteriskField">
        *
       </span>
      </label>
      <input class="form-control" id="pro_precio" name="pro_precio" type="text" value="<?=$pro_precio; ?>"/>
      <span class="help-block" id="hint_email">
       Ingrese el precio
      </span>
     </div>

     <div class="form-group">
      <label class="control-label requiredField" id="pro_stock" for="pro_stock">
       Stock
       <span class="asteriskField">
        *
       </span>
      </label>
      <input class="form-control" id="pro_stock" name="pro_stock" type="text" value="<?=$pro_stock; ?>"/>
      <span class="help-block" id="hint_subject">
       Ingrese el stock
      </span>
     </div>

    <?php

    $query = "SELECT mar_id,mar_descripcion FROM marcas ORDER BY 2 ASC";
    $result = pg_query($conexion, $query);
    $rowCount = pg_num_rows($result);
    ?>
        <div class="form-group">
            <label class="control-label requiredField" id="pro_stock" for="pro_stock">
             Marca
            </label>
            <select name="marca" id="marca" class="selectpicker form-control" data-live-search="true">
                <option disabled>Seleccione la Marca</option>
                <?php
                
                if($rowCount > 0){
                    while($row = pg_fetch_row($result)){
                        if($row[0]==$mar_id2)
                            echo "<option value='$row[0]' selected>$row[1]</option>";
                        else
                          echo "<option value='$row[0]'>$row[1]</option>";
                    }
                }else{
                    echo '<option disabled>Marca no habilitado</option>';
                }
                ?>
            </select>
        </div>
        
       <button class="btn btn-primary " name="submit" type="submit">
        Guardar Modificacion
       </button>

       <a href='?p=productos' class='btn btn-info btn-sm' role='button'>Cancelar</a>

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