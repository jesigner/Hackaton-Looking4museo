<?php
require('util/conexionBD.php');

$nombre= !empty($_POST['name']) ? $_POST['name'] :'';
$email= !empty($_POST['email']) ? $_POST['email'] :'';
$msg= !empty($_POST['msg']) ? $_POST['msg'] :'';



$consulta=<<<FIN
insert into sugerencia
(nombre,correo,comentario)
values
('$nombre','$email','$msg')
FIN;

mysql_query($consulta) or die("no se pudo insertar el registro <br> $consulta");

?>
