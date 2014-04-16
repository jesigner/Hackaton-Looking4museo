<?php
//header("Content-Type: application/json");
require_once("../util/conexionBD.php");
error_reporting(E_ALL ^ E_NOTICE);



if ($_POST["opcion"] === "cargarCategorias") {
    $conn = connectMYSQL::openConnection();
    $consult = "SELECT * FROM Categoria";
    $result = $conn->query($consult);
    $html = "";
    $html = "<option value=0>--Elije--</option>";
    while ($row = $result->fetch_assoc()) {
    	$st_codigoC = $row['idCategoria'];
    	$st_nombreC = $row['nombre'];    	
    	$html .="<option value='$st_codigoC'>$st_nombreC</option>";
    } 
}else if($_POST["opcion"] === "cargarDistritos"){
	$conn = connectMYSQL::openConnection();
    $consult = "SELECT * FROM Distrito";
    $result = $conn->query($consult);
    $html = "";
    $html = "<option value=0>--Elije--</option>";
    while ($row = $result->fetch_assoc()) {
    	$st_codigoD = $row['idDistrito'];
    	$st_nombreD = $row['nombre'];
    	$html .="<option value='$st_codigoD'>$st_nombreD</option>";
    } 
    $conn->close();
    echo $html;
}else if($_POST["opcion"] === "cargarMuseos"){
	$idCategoria = "";
	$idMuseo = "";
	$idDistrito = "";

	if($_POST["txtIdCategoria"] !== "" || $_POST["txtIdMuseo"] !== "" || $_POST["txtIdDistrito"] !== ""){
		$idCategoria = $_POST["txtIdCategoria"];
		$idMuseo = $_POST["txtIdMuseo"];
		$idDistrito = $_POST["txtIdDistrito"];
	}else{

	}
    $conn = connectMYSQL::openConnection();
    $consult = "SELECT m.nombre,m.direccion,m.email,m.web,m.telefono,m.horario,c.nombre as categoria,u.nombre as ubicacion,d.nombre as distrito FROM Museo m
    			inner join Categoria c using(idCategoria) 
    			inner join Ubicacion u using(idUbicacion)
    			inner join Distrito d using(idDistrito)
    			where m.idMuseo regexp '^$idMuseo' and c.categoria regexp '^$idCategoria' and d.nombre regexp '^$idDistrito' ";
    
	echo "[";
    $result = $conn->query($consult);
	
	while ($row = $result->fetch_assoc()) {
	        $st_codigo = $idMuseo;
	        $st_nombre = utf8_encode($row['nombre']);
	        $st_direccion = utf8_encode($row['direccion']);
	        $st_email = utf8_encode($row['email']);
	        $st_web = utf8_encode($row['web']);
	        $st_telefono = utf8_encode($row['telefono']);
	        $st_horario = utf8_encode($row['horario']);
	        $st_categoria = utf8_encode($row['categoria']);
	        $st_ubicacion = utf8_encode($row['ubicacion']);
	        $st_distrito = utf8_encode($row['distrito']);

	    $arraydata = [
    		    'nombre' => $st_nombre,
                'direccion' => $st_direccion,
                'email' => $st_email,
                'web' => $st_web,
                'telefono' => $st_telefono,
                'horario' => $st_horario,
                'categoria' => $st_categoria,
                'ubicacion' => $st_ubicacion,
                'distrito' => $st_distrito
            ];
            echo json_encode($arraydata);
            echo ","; 
	}
	echo "{}]";
    $conn->close();
}else if($_REQUEST["opcion"] === "cargarEventos"){
	$hoy = date("Y-m-d");
	$fechas = date( "Y-m-d", strtotime( "-1 month", strtotime( $hoy ) ) ); //fechas desde un mes atras
    $conn = connectMYSQL::openConnection();
    $consult = "SELECT e.idEvento,e.nombre,e.descripcion,e.fechaInicio,e.fechaFin,e.horario,m.nombre as museo,m.direccion FROM Evento e
    			inner join Museo m using(idMuseo) where e.fechaInicio > '$fechas'";
    $result = $conn->query($consult);
    echo "{\"eventos\" : [";
	while ($row = $result->fetch_assoc()) {
	        $st_codigo = utf8_encode($row['idEvento']);
	        $st_nombre = utf8_encode($row['nombre']);
            $st_descripcion = utf8_encode($row['descripcion']);
	        $st_fechaInicio = utf8_encode($row['fechaInicio']);
	        $st_fechaFin = utf8_encode($row['fechaFin']);
	        $st_museo = utf8_encode($row['museo']);
	        $st_direccion = utf8_encode($row['direccion']);
	        $year = substr($st_fechaInicio,0, 4);
			$month = substr($st_fechaInicio, 5,-3);
			$day = substr( $st_fechaInicio, 8);
            $year2 = substr($st_fechaFin,0, 4);
            $month2 = substr($st_fechaFin, 5,-3);
            $day2 = substr($st_fechaFin, 8);
			$arraydata = [
    		    'title' => $st_nombre,
                'descripcion' => $st_descripcion,
                'startyear' => $year,
                'startmonth' => $month,
                'startday' => $day,
                'endyear' => $year2,
                'endmonth' => $month2,
                'endday' => $day2,
                'allDay' => 'false',
                'website' => $st_web,
                'url' => "javascript:evento.crearPantalla($day)"          
            ];
            echo json_encode($arraydata);
            echo ",";    
        }
    echo "{}]}"; 
    $conn->close();
    	
    

}else if($_POST["opcion"] === "guardarImagen"){
	$idMuseo = $_POST['idMuseo'];
	$nombre = $_POST['nombre'];
	$nombreFoto = $_FILES['foto']['name'];
	$rutaFoto = $_FILES['foto']['tmp_name'];
	$destino = 'fotos/'.$nombreFoto;//maS ID para q nolo suplante
	copy($rutaFoto,$destino);

	$conn = connectMYSQL::openConnection();
    $consult = "INSERT INTO imagenes(idMuseo,nombre,direccion) values ('$idMuseo',$nombre','$destino')";
    $result = $conn->query($consult);
    header("Location:index.php");
}
