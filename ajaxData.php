<?php
include 'paginas/conexion.php';

if(isset($_POST["pa_id"]) && !empty($_POST["pa_id"])){

    extract($_POST);
    $query = "SELECT * FROM provincias WHERE pa_id = '$pa_id'";
    $result = pg_query($conexion, $query);
    
    $rowCount = pg_num_rows($result);

    if($rowCount > 0){
        echo "<option >Seleccione provincia</option>";
        while($row = pg_fetch_row($result)){ 
            echo "<option value='$row[0]'>$row[1]</option>";
        }
    }else{
        echo '<option value="">provincias no habilitadas</option>';
    }
}

if(isset($_POST["pr_id"]) && !empty($_POST["pr_id"])){
    
    extract($_POST);
    $query = "SELECT dep_id,dep_nombre FROM departamentos WHERE pr_id = $pr_id ";
    $result = pg_query($conexion, $query);
    
    $rowCount = pg_num_rows($result);
    
    if($rowCount > 0){
        echo "<option >Seleccione Departamento</option>";
        while($row = pg_fetch_row($result)){ 
            echo "<option value='$row[0]'>$row[1]</option>";
        }
    }else{
        echo "<option >Departamentos no habilitados $rowCount en $pr_id </option>";
    }
}

if(isset($_POST["dep_id"]) && !empty($_POST["dep_id"])){
    
    extract($_POST);
    $query = "SELECT ciu_id,ciu_nombre FROM ciudades WHERE dep_id = $dep_id ORDER BY ciu_nombre ASC";
    $result = pg_query($conexion, $query);
    
    $rowCount = pg_num_rows($result);
    
    if($rowCount > 0){
        echo '<option value="">Seleccione Ciudad</option>';
        while($row = pg_fetch_row($result)){ 
            echo "<option value='$row[0]'>$row[1]</option>";
        }
    }else{
        echo '<option disabled>Ciudades no habilitadas</option>';
    }
}

if(isset($_POST["pro_id"]) && !empty($_POST["pro_id"])){
    
    extract($_POST);
    $query = "SELECT pro_precio,mar_descripcion FROM productos INNER JOIN marcas USING(mar_id) WHERE pro_id=$pro_id";
    $result = pg_query($conexion, $query);
    $rowCount = pg_num_rows($result);
    //header('Content-type: application/json');
    if($rowCount>0){
        $row = pg_fetch_array($result);
        echo json_encode(array('marca' => $row[1],'precio' => $row[0]));
    } else {
        echo json_encode(array('marca' => 'no habilitado','precio' => 'no habilitado'));
    }
}

?>