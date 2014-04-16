<?php
//requeriendo el modulo de conexión
require_once("../util/conexionBD.php");
// Condicion para la operacion 
if (!empty($_POST["opcion"])) {
    //Condicion para manipular el tipo de operacion con un procedimiento especifico
    if ($_POST["opcion"] === "cargarMuseos"){
        //Instanciando una conexión de forma estatica
        $conn = connectMYSQL::openConnection();
        //Estableciando una consulta almacenado en una variable
            $consult = "SELECT mus.idMuseo,mus.nombre,mus.latitud,mus.longitud,mus.direccion,mus.horario,mus.telefono,mus.web FROM Museo as mus";
            //Ejecutando la consulta y obteniendo un resultado
            $result = $conn->query($consult);
            //Inicializando la variable html para el response
            $st_cod="";
            $st_nombre="";      
            echo "[";
            //Iterando el result por cada registro
            while ($row = $result->fetch_assoc()) {
                //Leyendo los datos del array asociativo
                $st_cod = utf8_encode($row['idMuseo']);
                $st_nombre = utf8_encode($row['nombre']);
                $st_latitud = utf8_encode($row['latitud']);
                $st_longitud = utf8_encode($row['longitud']);
                $st_horario = utf8_encode($row['horario']);
                $st_direccion = utf8_encode($row['direccion']);
                $st_telefono = utf8_encode($row['telefono']);
                $st_web = utf8_encode($row['web']);

                $arraydata = [
                    'codigo' => $st_cod,
                    'nombre' => $st_nombre,
                    'latitud' => $st_latitud,
                    'longitud' => $st_longitud,
                    'horario' => $st_horario,
                    'direccion' => $st_direccion,
                    'telefono' => $st_telefono,
                    'web' => $st_web
                ];
                echo json_encode($arraydata);
                echo ",";
                //Establecido codigo HTML en la variable $html para el response  
            }
            echo "{}]";
            $conn->close();
            //Cerrando la conexión
    }else if ($_POST["opcion"] === "cargarGaleriaImagenes"){
        $conn = connectMYSQL::openConnection();
        //Estableciando una consulta almacenado en una variable
        $codigo = $_POST["codigo"];
        $consult = "SELECT idImagenes,nombre,direccion,idMuseo 
                    FROM Imagenes 
                    WHERE idMuseo = $codigo";
        //Ejecutando la consulta y obteniendo un resultado
        $result = $conn->query($consult);
            //Inicializando la variable html para el response    
            echo "[";
            //Iterando el result por cada registro
            while ($row = $result->fetch_assoc()) {
                //Leyendo los datos del array asociativo
                $st_cod = utf8_encode($row['idImagenes']);
                $st_nombre = utf8_encode($row['nombre']);
                $st_direccion = utf8_encode($row['direccion']);
                $st_idMuseo = utf8_encode($row['idMuseo']);

                $arraydata = [
                    'codigo' => $st_cod,
                    'nombre' => $st_nombre,
                    'direccion' => $st_direccion,
                    'idMuseo' => $st_idMuseo
                ];
                echo json_encode($arraydata);
                echo ",";
                //Establecido codigo HTML en la variable $html para el response  
            }
            echo "{}]";
            $conn->close();
    }
}else if($_POST["opcion"] === "aumentarRanking"){
        /*$conn = connectMYSQL::openConnection();
        //Estableciando una consulta almacenado en una variable
        $codigo = $_POST["codigo"];
        $consult = "UPDATE FROM Museo 
                    SET votos=votos+1 
                    WHERE idMuseo = $codigo";
        $result = $conn->query($consult);
        $consult2 = "SELECT votos FROM Museo WHERE idMuseo = $codigo";
        $result2 =$conn->query($consult2);
        while ($row = $result->fetch_assoc()) 
        {

        }*/
        echo "Aumentando el Ranking";
}else {
    echo "no hay operación";
}