$(document).on("ready", start);
function start() {
    CargarEjemplo()
    alert(":S");
}

function cargarCategorias() {
    $.post("Controller.php",{opcion: "cargarCategorias"}, function(resp) {
        var response = resp.toString();
        $("#").html(response);
    });
}

function CargarUbicaciones() {
    $.post("Controller.php",{opcion: "cargarUbicaciones"}, function(resp) {
        var response = resp.toString();
        $("#").html(response);
    });
}

function CargarDistritos() {
    $.post("Controller.php",{opcion: "cargarDistritos"}, function(resp) {
        var response = resp.toString();
        $("#").html(response);
    });
}

function CargarMuseos() {
    $.post("Controller.php",{opcion: "cargarMuseos"}, function(resp) {
        var response = resp.toString();
        $("#").html(response);//Contenido de los museos
    });
}

function CargarEventos() {
    $.post("Controller.php",{opcion: "cargarEventos"}, function(resp) {
        var response = resp.toString();
        $("#").text(response);//Contenido de los museos
    });
}

function guardarImagen() {
    $.post("Controller.php",{opcion: "guardarImagen"}, function(resp) {
        var response = resp.toString();
        
    });
}