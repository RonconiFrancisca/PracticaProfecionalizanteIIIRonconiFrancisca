function abrirVentana(btn) {
    document.getElementById("ventanaEditar").style.display = "flex";
    document.getElementById("id_examen").value = btn.dataset.id;
    document.getElementById("nota_nuevo").value = btn.dataset.nota;
    document.getElementById("fecha_nuevo").value = btn.dataset.fecha;
    document.getElementById("id_alumno_nuevo").value = btn.dataset.idAlumno;
    document.getElementById("id_materia_nuevo").value = btn.dataset.idMateria;
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