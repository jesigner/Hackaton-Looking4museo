$(document).on("ready" , iniciarMapa);

function iniciarMapa(){
	mostrarMapa();
	mostrarMuseos();
}

function mostrarMapa(){
	//Creando el mapa
	$('#zonaMapa').gmap().bind('init', function(evt, map) {
		$('#zonaMapa').gmap('getCurrentPosition', function(position, status) {
			if ( status === 'OK' ) {
				var clientPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				
				var $marker = $('#zonaMapa').gmap('addMarker', {
					'icon' : "images/userLocalizado_editado-1.png",
					'position': clientPosition, 
					'bounds': true
				});
				
				$marker.click(function(){
					$('#zonaMapa').gmap('openInfoWindow',{'content': "Esta es mi posición"},this);	
				});

			}else{
				$("#notificadorMapa").html("GPS no encontrado, Por favor activar GPS del dispositivo");
			}
		});   
	});
}

function crearMarcador(codigo,latitude,longitude,nombre,horario,direccion,telefono,web){
	//Asignando un contructor
	$('#zonaMapa').gmap({'some_option':'some_value'}); 
	//Añadiendo un marcador 
	var $marker = $('#zonaMapa').gmap('addMarker', {
		'id' : codigo,
		'position': latitude+","+longitude,
		'icon' : "images/museoLocalizado.png",
		'bounds': true
	});
	//Asignando 
	$marker.click(function(){
		$('#zonaMapa').gmap('openInfoWindow',{
			'content': "<div class='infoMuseos'><header>"+nombre+"<a href='#zonaMapa' id='ranking'><i class='fa fa-check-circle fa-lg'></i></a><a href='#zonaMapa' id='rutaMapa'><i class='fa fa-truck fa-lg'></i></a></header><section><p><i class='fa fa-clock-o fa-lg'></i>    "+horario+"</p><p><i class='fa fa-map-marker fa-lg'></i>    "+direccion+"</p><p><i class='fa fa-phone fa-lg'></i>    "+telefono+"</p><p><i class='fa fa-globe fa-lg'></i>   <a href=http://"+web+">"+web+"</a>  <a href='#openModal' onclick='pintarRuta("+latitude+","+longitude+","+codigo+")' id='galeriaImagenes' title='Galeria de Imagenes'><i class='fa fa-picture-o fa-lg'></i></a></p></section></div>"
		},
		this);
	});
}

var $i;
function mostrarMuseos(){
	$.post("patron/controlador/mapaController.php",{opcion : "cargarMuseos"},function(resp){
		  //alert(resp[0]["codigo"]+resp[0]["latitud"]+resp[0]["longitud"]);
		  $i = JSON.parse(resp);
		  for (var x=0;x<$i.length-1;x++){
		  	crearMarcador($i[x].codigo,$i[x].latitud,$i[x].longitud,$i[x].nombre,$i[x].horario,$i[x].direccion,$i[x].telefono,$i[x].web);	
		  }
	});
}
var $y;
function pintarRuta(latitude,longitude,codigo){
	var data = "opcion=cargarGaleriaImagenes&codigo="+codigo+"";
	$.post("patron/controlador/mapaController.php",data,function(resp){
		  $y = JSON.parse(resp);
		  var slider,thumb;
		  for (var x=0;x<$y.length-1;x++){
		  	slider = slider+ "<li id='slide"+(x+1)+"' ><a href='#'><img src='"+$y[x].direccion+"/></a></li>";
		  }
		  for (var x=0;x<$y.length-1;x++){
		  	thumb = thumb + "<li><a href='#slide"+(x+1)+"'><img src='"+$y[x].direccion+"'/></a></li>";
		  }
		  $("#slider").html(slider);
		  $("#thumb").html(thumb);
	});
}

/*function aumentarRanking(codigo){
	$.post("patron/controlador/mapaController.php",{opcion : "aumentarRanking"},function(resp){
		resp
	}
}*/
 
