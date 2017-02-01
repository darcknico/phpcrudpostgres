        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Administrador de Clientes - Editar</h1>
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Modificacion Cliente
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
    if (!$error){
      $query = "update clientes set cli_apellido='$cli_apellido',cli_nombre='$cli_nombre',cli_domicilio='$cli_domicilio',ciu_id=$ciu_id where cli_id=$cli_id ";
      if (pg_query($conexion, $query)){
        $guardado = true;
        $mensaje[]="El cliente se modifco correctamente";
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
            echo "<a href='?p=clientes' class='btn btn-info btn-sm' role='button'>Lista de clientes</a>";
        }else{

        if (isset($_GET)){
          $estado="INCIAL";
          extract($_GET);
        }
        if (isset($_POST['submit'])){
          extract($_POST);
        }
        if (!isset($cli_id) or $cli_id==''){
          $error=true;
          $mensaje[]="Parámetros incompletos";
        } 
        else 
        {

          $query1 = "SELECT cli_apellido,cli_nombre,cli_domicilio,ciu_id,cli_id,dep_id,pr_id,pa_id FROM clientes ".
            "LEFT JOIN ciudades using(ciu_id) INNER JOIN departamentos using(dep_id) INNER JOIN provincias using(pr_id) INNER JOIN paises using(pa_id)".
            " WHERE cli_id=$cli_id";
          $result1 = pg_query($conexion, $query1);
          $rowCount = pg_num_rows($result1);
          if($rowCount>0){
            $row = pg_fetch_array($result1);
            $cli_apellido = $row[0];
            $cli_nombre = $row[1];
            $cli_domicilio = $row[2];
            $ciu_id = $row[3];
            $cli_id2 = $row[4];
            $dep_id = $row[5];
            $pr_id = $row[6];
            $pa_id = $row[7];

          }
        }
     ?>

    <form method="post">

    <input type="hidden" name="cli_id" id="cli_id" value="<?=$cli_id; ?>">
     
     <div class="form-group">
      <label class="control-label requiredField" for="cli_apellido">
       Apellido
       <span class="asteriskField">
        *
       </span>
      </label>
      <input class="form-control" id="cli_apellido" name="cli_apellido" type="text" value="<?=$cli_apellido; ?>"/>
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
      <input class="form-control" id="cli_nombre" name="cli_nombre" type="text" value="<?=$cli_nombre; ?>"/>
      <span class="help-block" id="hint_email">
       Ingrese su nombre
      </span>
     </div>

     <div class="form-group">
      <label class="control-label requiredField" id="cli_domicilio" for="cli_domicilio">
       Domicilio
       <span class="asteriskField">
        *
       </span>
      </label>
      <input class="form-control" id="cli_domicilio" name="cli_domicilio" type="text" value="<?=$cli_domicilio; ?>"/>
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
            <select name="pa_id" id="pais" class="form-control">
                <option value="">Seleccione el Pais</option>
                <?php
                
                if($rowCount > 0){
                    while($row = pg_fetch_row($result)){
                          echo "<option value='$row[0]'>$row[1]</option>";
                    }
                }else{
                    echo '<option disable>Pais no habilitado</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label class="control-label">
               Provincia
            </label>
            <select name="pr_id" id="provincia" class="form-control">
                <option value="">Seleccione pais primero</option>
            </select>
        </div>

        <div class="form-group">
            <label class="control-label">
               Departamento
            </label>
            <select name="dep_id" id="departamento" class="form-control">
                <option value="">Seleccione provincia primero</option>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">
               Ciudad
            </label>
            <select name="ciu_id" id="ciudad" class="form-control">
                <option value="">Seleccione ciudad primero</option>
            </select>
        </div>

       <button class="btn btn-primary " name="submit" type="submit">
        Guardar Modificacion
       </button>

       <a href='?p=clientes' class='btn btn-info btn-sm' role='button'>Cancelar</a>

    </form>

  <script type="text/javascript">
    $(document).ready(function(){

        $('#pais').change(function(){
        var paisId = $('#pais').val();
            if(paisId){
                $.ajax({
                    type:"post",
                    url:"ajaxData.php",
                    data: {"pa_id":paisId},
                    success:function(html){
                        $('#provincia').html(html);
                        $('#departamento').html('<option value="">Selecciona provincia primero</option>');
                        $('#ciudad').html('<option value="">Selecciona provincia primero</option>');

                        //$('#provincia').val("<?=$pr_id; ?>").change();
                        $('#provincia option').each(function(){
                            var bus = "<?=$pr_id; ?>";
                            if (this.value == bus) {
                              $('#provincia').val(bus).change();
                            }
              });
            }
                }); 
            }else{
                $('#provincia').html('<option value="">Selecciona pais primero</option>');
                $('#departamento').html('<option value="">Selecciona pais primero</option>'); 
                $('#ciudad').html('<option value="">Selecciona pais primero</option>');
            }
        });

      $('#pais').val("<?=$pa_id; ?>").change();

        $('#provincia').on('change',function(){
            var provinciaID = $(this).val();
            if(provinciaID){
                $.ajax({
                    type:'POST',
                    url:'ajaxData.php',
                    data:{'pr_id':provinciaID},
                    success:function(html){
                        $('#departamento').html(html);
              $('#ciudad').html('<option value="">Selecciona departamento primero</option>');

              //$('#departamento').val("<?=$dep_id; ?>").change();
              $('#departamento option').each(function(){
                var bus = "<?=$dep_id; ?>";
                if (this.value == bus) {
                  $('#departamento').val(bus).change();
                }
              });
                    }
                }); 
            }else{
                $('#departamento').html('<option value="">Selecciona provincia primero</option>'); 
                $('#ciudad').html('<option value="">Selecciona provincia primero</option>');
            }
        });

        $('#departamento').on('change',function(){
            var departamentoID = $(this).val();
            if(departamentoID){
                $.ajax({
                    type:'POST',
                    url:'ajaxData.php',
                    data:'dep_id='+departamentoID,
                    success:function(html){
                        $('#ciudad').html(html);

              //$('#ciudad').val("<?=$ciu_id; ?>");
              $('#ciudad option').each(function(){
                var bus = "<?=$ciu_id; ?>";
                if (this.value == bus) {
                  $('#ciudad').val(bus).change();
                }
              });
                    }
                }); 
            }else{
                $('#ciudad').html('<option value="">Selecciona departamento primero</option>');
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