function abrirVentana(btn) {
    document.getElementById("ventanaEditar").style.display = "flex";
    document.getElementById("id_alumno").value = btn.dataset.id;
    document.getElementById("nombre_nuevo").value = btn.dataset.nombre;
    document.getElementById("email_nuevo").value = btn.dataset.email;
    document.getElementById("dni_nuevo").value = btn.dataset.dni;
    document.getElementById("fecha_nacimiento_nueva").value = btn.dataset.fechaNacimiento;
    document.getElementById("carrera_nueva").value = btn.dataset.carrera;
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