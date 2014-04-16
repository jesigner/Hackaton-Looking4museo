var $datos
function retornarEventos(){
	$.post("http://localhost/Hackaton-Looking4museo/patron/controlador/Controller.php",{opcion : "cargarEventos"},function(resp){
		console.log("Resp" + resp)
		$datos = JSON.parse(resp)
		return $datos
	});
}
retornarEventos()
var Eventos = function(){
	console.log("Instancia de Eventos")
	//this.eventos = retornarEventos()
	console.log("Datos: " + $datos)
	//this.dia = this.eventos[0].start

	ese = this
	this.crearPantalla = function(){
		var ventanita = document.createElement("div")
		ventanita.setAttribute("id","ventanita")
		ventanita.ondblclick = function(evento){ese.eliminarPantalla()}
		var h2 = document.createElement("h2")
		var titulo = document.createTextNode("Eventos del " + $datos.eventos[1].startday)
		h2.appendChild(titulo)
		ventanita.appendChild(h2)
		
		//Agregar los eventos
		var nombreEvento = document.createElement("h3")
		var nombreEventoTexto = document.createTextNode($datos.eventos[1].title)
		nombreEvento.appendChild(nombreEventoTexto)
		ventanita.appendChild(nombreEvento)
		var descripcionEvento = document.createElement("p")
		var descripcionEventoTexto = document.createTextNode($datos.eventos[1].descripcion)
		descripcionEvento.appendChild(descripcionEventoTexto)
		ventanita.appendChild(descripcionEvento)

		var contenedor = document.getElementById("principal")

		contenedor.appendChild(ventanita)
	}

	this.eliminarPantalla = function(){
		document.getElementById("ventanita").parentNode.removeChild(document.getElementById("ventanita"))
	}
}

var Evento = new Eventos()

$(document).ready(function() {


	$('#calendario').fullCalendar({
	editable: true,
	events: [
		{
			title: 'Hay eventos',
			start: new Date(2014, 3, 14),
			url: 'javascript:Evento.crearPantalla()'
		}
	],
	dayNames: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre']
});
});