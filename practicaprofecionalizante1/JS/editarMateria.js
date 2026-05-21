function abrirVentana(btn) {
    document.getElementById("ventanaEditar").style.display = "flex";
    document.getElementById("id_materia").value = btn.dataset.id;
    document.getElementById("nombre_nuevo").value = btn.dataset.nombre;
    document.getElementById("curso_nuevo").value = btn.dataset.curso;
    document.getElementById("id_carrera_nuevo").value = btn.dataset.Carrera;
    document.getElementById("id_profesor_nuevo").value = btn.dataset.Profesor;
    document.getElementById("nota_aprobacion_nueva").value = btn.dataset.notaAprobacion;
}

function cerrarVentana() {
    document.getElementById("ventanaEditar").style.display = "none";
}

function abrirVentanaCrear() {
    document.getElementById("ventanaCrear").style.display = "flex";
}

function cerrarVentanaCrear() {
    document.getElementById("ventanaCrear").style.display = "none";
}