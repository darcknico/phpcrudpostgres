
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Administrador de Clientes - Agregar</h1>
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Campos para un Nuevo Cliente
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
        if (!isset($cli_apellido) or $cli_apellido==''){
            $error=true;
            $mensaje[]="clienteid no puede estar vacío";
        }
        if (!isset($cli_nombre) or $cli_nombre==''){
            $error=true;
            $mensaje[]=" cli_nombre no puede estar vacío";
        }
    if (!isset($ciu_id) or $ciu_id==''){
      $error=true;
      $mensaje[]=" ciu_id no puede estar vacío";
    }
        if (!$error){
            $query = "insert into clientes(cli_apellido, cli_nombre, cli_domicilio,ciu_id) values('$cli_apellido','$cli_nombre','$cli_domicilio',$ciu_id);";
            if (pg_query($conexion, $query)){
                $guardado = true;
                $mensaje[]="El cliente se guardó correctamente";
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
            echo "<a href='?p=clientes' class='btn btn-info btn-sm' role='button'>Lista de clientes</a>";
    }else{
        ?>
   <form method="post">
     
     <div class="form-group">
      <label class="control-label requiredField" for="cli_apellido">
       Apellido
       <span class="asteriskField">
        *
       </span>
      </label>
      <input class="form-control" id="cli_apellido" name="cli_apellido" placeholder="Apellido" type="text" value=""/>
      <span class="help-block" id="hint_">
       Ingrese su apellido   
      </span>
     </div>

     <div class="form-group">
      <label class="control-label requiredField" for="cli_nombre">
       Nombre
       <span class="asteriskField">
        *
       </span>
      </label>
      <input class="form-control" id="cli_nombre" name="cli_nombre" placeholder="Nombre" type="text" value=""/>
      <span class="help-block" id="hint_email">
       Ingrese su nombre
      </span>
     </div>

     <div class="form-group">
      <label class="control-label requiredField" id="cli_domicilio" name="cli_domicilio" for="cli_domicilio">
       Domicilio
       <span class="asteriskField">
        *
       </span>
      </label>
      <input class="form-control" id="cli_domicilio" name="cli_domicilio" placeholder="Domicilio" type="text" value=""/>
      <span class="help-block" id="hint_subject">
       Ingrese su direccion
      </span>
     </div>

    <?php

    $query = "SELECT pa_id,pa_nombre FROM paises ORDER BY pa_nombre ASC";
    $result = pg_query($conexion, $query);
    $rowCount = pg_num_rows($result);
    ?>
        <div class="form-group">
            <label class="control-label">
               Pais
            </label>
            <select name="pais" id="pais" class="form-control">
                <option value="">Seleccione el Pais</option>
                <?php
                
                if($rowCount > 0){
                    while($row = pg_fetch_row($result)){ 
                        echo "<option value='$row[0]'>$row[1]</option>";
                    }
                }else{
                    echo '<option value="">Pais no habilitado</option>';
                }
                ?>
            </select>
        </div>
    
        <div class="form-group">
            <label class="control-label" for="provincia">
               Provincia
            </label>
            <select name="provincia" id="provincia" class="form-control">
                <option value="">Seleccione pais primero</option>
            </select>
        </div>
    
        <div class="form-group">
            <label class="control-label">
               Departamento
            </label>
            <select name="departamento" id="departamento" class="form-control">
                <option value="">Seleccione pais primero</option>
            </select>
        </div>
    
        <div class="form-group">
            <label class="control-label">
               Ciudad
            </label>
            <select name="ciu_id" id="ciudad" class="form-control">
                <option value="">Seleccione pais primero</option>
            </select>
        </div>

       <button class="btn btn-primary " name="submit" type="submit">
        Guardar
       </button>

    </form>

    
    <script type="text/javascript">
      $(document).ready(function(){
          $('#pais').change(function(){
              var id = $('#pais').val();
              if(id){
                  $.ajax({
                      type:"post",
                      url:"ajaxData.php",
                      data: {"pa_id":id},
                      success:function(html){
                          $('#provincia').html(html);
                          $('#departamento').html('<option value="">Seleccione provincia primero</option>'); 
                          $('#ciudad').html('<option value="">Selecciona provincia primero</option>');
                      }
                  });
              }else{
                  $('#provincia').html('<option value="">Seleccione pais primero</option>');
                  $('#departamento').html('<option value="">Seleccione pais primero</option>'); 
              }
          });

          $('#provincia').change(function(){
              var id = $(this).val();
              if(id){
                  $.ajax({
                      type:'POST',
                      url:'ajaxData.php',
                      data: {"pr_id":id},
                      success:function(html){
                          $('#departamento').html(html);
                          $('#ciudad').html('<option value="">Selecciona Departamento primero</option>');
                      }
                  }); 
              }else{
                  $('#departamento').html('<option value="">Seleccione provincia primero</option>'); 
              }
          });

          $('#departamento').on('change',function(){
              var id = $(this).val();
              if(id){
                  $.ajax({
                      type:'POST',
                      url:'ajaxData.php',
                      data:{"dep_id":id},
                      success:function(html){
                          $('#ciudad').html(html);
                      }
                  }); 
              }else{
                  $('#departamento').html('<option value="">Seleccione ciudad primero</option>'); 
              }
          });
      });
    </script>
    
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