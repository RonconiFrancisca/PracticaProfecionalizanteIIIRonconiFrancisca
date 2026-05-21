let suma = 0;
let secuencia = [];
let i = 0;
let tiempoRespuesta;
let respuestaIngresada = false;

// Array fijo en el sistema
const numerosPosibles = [1,2,3,4,5,6,7,8,9,10];

function secuenciaNumeros() {
    suma = 0;
    i = 0;
    respuestaIngresada = false;

    const input = document.getElementById('respuesta');
    input.disabled = true;
    input.value = "";

    const btnVerificar = document.getElementById('btnVerificar');
    btnVerificar.disabled = true;

    document.getElementById("mostrarcorrecto").innerHTML = "";
    document.getElementById("mostrarincorrecto").innerHTML = "";

    // Elegir cantidad aleatoria de 3 a 5 números
    const cantidadAlazar = Math.floor(Math.random() * 3) + 3;

    // Generar secuencia aleatoria desde numerosPosibles
    const copiaArray = [...numerosPosibles];
    secuencia = [];
    for(let j=0;j<cantidadAlazar;j++){
        const idx = Math.floor(Math.random() * copiaArray.length);
        secuencia.push(copiaArray[idx]);
        copiaArray.splice(idx,1);
    }

    suma = secuencia.reduce((acc,num)=>acc+num,0);

    mostrarSiguiente();
}

function mostrarSiguiente() {
    const mostrar = document.getElementById("mostrar");

    if(i >= secuencia.length){
        mostrar.innerHTML = "";
        const input = document.getElementById('respuesta');
        input.disabled = false;

        const btnVerificar = document.getElementById('btnVerificar');
        btnVerificar.disabled = false;

        // Temporizador de 5s para ingresar respuesta
        clearTimeout(tiempoRespuesta);
        tiempoRespuesta = setTimeout(()=>{
            if(!respuestaIngresada){
                document.getElementById("mostrarincorrecto").innerHTML =
                    "Se acabó el tiempo. La suma era: " + suma;
                input.disabled = true;
                btnVerificar.disabled = true;
            }
        },5000);
        return;
    }

    mostrar.innerHTML = secuencia[i];
    i++;

    // Esperar 3s y luego ocultar 1.5s antes del siguiente
    setTimeout(()=>{
        mostrar.innerHTML = "";
        setTimeout(mostrarSiguiente,1500);
    },3000);
}

function compararSuma() {
    respuestaIngresada = true;
    clearTimeout(tiempoRespuesta);

    const input = document.getElementById('respuesta');
    const btnVerificar = document.getElementById('btnVerificar');
    input.disabled = true;
    btnVerificar.disabled = true;

    const respuestaArray = input.value.split(',').map(x=>Number(x.trim()));
    const sumaUsuario = respuestaArray.reduce((acc,num)=>acc+num,0);

    document.getElementById("mostrarcorrecto").innerHTML = "";
    document.getElementById("mostrarincorrecto").innerHTML = "";

    if(sumaUsuario === suma){
        document.getElementById("mostrarcorrecto").innerHTML = "Es correcto";
    } else {
        document.getElementById("mostrarincorrecto").innerHTML =
            "Es Incorrecto. La suma era: " + suma;
    }
}