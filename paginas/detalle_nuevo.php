
    <script type="text/javascript" src="js/moment.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="js/transition.js"></script>
    <script type="text/javascript" src="js/collapse.js"></script>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Administrador de Facturas - Editar - Agregar Detalle</h1>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Campos para un nuevo detalle
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
        if (!isset($cantidad) or $cantidad=='' or $cantidad<0){
            $error=true;
            $mensaje[]="La cantidad no puede estar vacío o ser negativo";
        }
        if (!isset($producto) or $producto==''){
            $error=true;
            $mensaje[]="El producto no puede estar vacio";
        }
      if (!isset($precio) or $precio==''){
        $error=true;
        $mensaje[]="El precio no puede estar vacio";
      }
        if (!$error){
            $query = "insert into detfacturas(fac_nro,pro_id,df_cant,df_preciounit) values($fac_nro,$producto,$cantidad,$precio)";
            if (pg_query($conexion, $query)){
                $guardado = true;
                $mensaje[]="El detalle se guardó correctamente";
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
            echo "<a href='?p=factura_editar&fac_nro=$fac_nro' class='btn btn-info btn-sm' role='button'>Volver a la Factura</a>";
        }else{
        if (!isset($_GET['fac_nro'])){
          echo "no existe nro de factura";
          echo "<a href='?p=factura_editar&fac_nro=$fac_nro' class='btn btn-info btn-sm' role='button'>Volver a la Factura</a>";
        } else {
          $estado="INCIAL";
          extract($_GET);
     ?>

      <form method="post">
        <div class="form-group">

        <input type="hidden" name="fac_nro" id="fac_nro" value="<?=$fac_nro; ?>">

      <?php
        $query = "SELECT pro_id,pro_descripcion FROM productos ORDER BY 2 ASC";
        $result = pg_query($conexion, $query);
        $rowCount = pg_num_rows($result);
        ?>
            <div class="form-group">
                <label class="control-label" for="pro_id">
                    Producto
                </label>
                <select name="producto" id="producto" class="form-control">
                    <option>Seleccione el Producto</option>
                    <?php
                    
                    if($rowCount > 0){
                        while($row = pg_fetch_row($result)){ 
                            echo "<option value='$row[0]'>$row[1]</option>";
                        }
                    }else{
                        echo '<option disabled>No hay registro</option>';
                    }
                    ?>
                </select>
            </div>

       <div class="form-group">
        <label class="control-label" for="marca">
         Marca del producto
        </label>
        <input class="form-control" id="marca" name="marca" placeholder="Marca del Producto" type="text" readonly/>
       </div>

       <div class="form-group" for="precio">
        <label class="control-label">
         Precio del producto por unidad
        </label>
        <div class="input-group">
            <span class="input-group-addon">$</span>
            <input class="form-control" id="precio" name="precio" placeholder="Precio del Producto" type="number" readonly />
        </div>
       </div>

       <div class="form-group">
        <label class="control-label requiredField" for="cantidad">
         Cantidad
         <span class="asteriskField">
          *
         </span>
        </label>
        <input class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad a llevar" type="number" value="0" disabled />
        <span class="help-block" id="hint_email">
         Ingrese la Cantidad
        </span>
       </div>

       <div class="form-group">
        <label class="control-label" for="subtotal">
         Subtotal
        </label>
        <div class="input-group">
            <span class="input-group-addon">$</span>
            <input class="form-control" id="subtotal" name="subtotal" placeholder="Subtotal a llevar" type="number" readonly />
        </div>
       </div>

           <button class="btn btn-primary " name="submit" type="submit">
            Guardar
           </button>

           <a href='?p=factura_editar&fac_nro=$fac_nro' class='btn btn-info btn-sm' role='button'>Volver a la Factura</a>

        </div>
        </form>

  <script type="text/javascript">
    $(document).ready(function(){
      $('#producto').on('change',function(){
        var proId = $('#producto').val();
        if(proId){
          $.ajax({
            type:"post",
            url:"ajaxData.php",
            data: {"pro_id":proId},
            dataType:'json',
            success:function(data){
              $('#marca').val(data.marca);
              $('#precio').val(data.precio);
              $('#cantidad').prop('disabled', false);
              var cantidad = Number($('#cantidad').val());
              var precio = Number(data.precio);
              $('#subtotal').val(cantidad*precio);
            },
            error:function(data){
                alert("error "+data);
            }
          }); 
        }else{
          $('#marca').val('Seleccione Producto primero');
          $('#precio').val('Seleccione Producto primero'); 
          $('#cantidad').prop('disabled', true);
        }
      });

      $('#cantidad').change(function(){
        var cantidad = Number($('#cantidad').val().replace(/[^0-9\.]+/g,""));
        var precio = Number($('#precio').val().replace(/[^0-9\.]+/g,""));
        $('#subtotal').val(cantidad*precio);
      });

    });
  </script>
  
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