let datos = [];
let preguntas = [];
let actual = 0;
let correctas = 0;
let incorrectas = 0;
let noRespondidas = 0;
let tiempo;
let intervalo;

// convertir el json en datos
fetch("trivia_realista_240.json")

  .then(res => res.json())
  
  .then(data => {
    console.log(data);
    datos = data.categorias;
    
    let select = document.getElementById("categoria");
    datos.forEach(cat => {
      let option = document.createElement("option");//busca las categorias y las agrega a el menu de categorias
      option.value = cat.nombre;
      option.textContent = cat.nombre;
      select.appendChild(option);
    });
  })
  .catch(() => {
    document.getElementById("error").textContent = "Error al cargar datos";
  });

// iniciar juego
document.getElementById("iniciar").addEventListener("click", () => {
  let categoria = document.getElementById("categoria").value; //va a la categoria selccionada

  if (!categoria) {
    document.getElementById("error").textContent = "Elegí una categoría";
    return;
  }

  document.getElementById("error").textContent = "";

  //LIMPIAR RESULTADOS ANTERIORES
  let divResultado = document.getElementById("resultado");
  divResultado.style.display = "none";
  divResultado.innerHTML = "";

  let cat = datos.find(c => c.nombre === categoria);

  // elige 5 preguntas aleatorias
  preguntas = cat.preguntas.sort(() => Math.random() - 0.5).slice(0, 5);

  actual = 0;
  correctas = 0;
  incorrectas = 0;
  noRespondidas = 0;

  document.getElementById("juego").style.display = "block";
  mostrarPregunta();
});

// mostrar pregunta
function mostrarPregunta() {
  if (actual >= 5) {
    mostrarResultado();
    return;
  }
  let p = preguntas[actual]; //agarra la pregunta
  document.getElementById("progreso").textContent = `Pregunta ${actual + 1} de 5`;
  document.getElementById("pregunta").textContent = p.pregunta; //muestra la pregunta actual

  let opciones = [...p.incorrectas, p.correcta];
  opciones.sort(() => Math.random() - 0.5); //mezcla las respuestas

  let contenedor = document.getElementById("opciones");
  contenedor.innerHTML = "";

  opciones.forEach(op => {
    let btn = document.createElement("button");//convierte a cada respuesta en un botton
    btn.textContent = op;

    btn.onclick = () => responder(btn, op, p.correcta);

    contenedor.appendChild(btn);
  });

  iniciarTiempo();
}

// tiempo
function iniciarTiempo() {
  tiempo = 10;
  document.getElementById("tiempo").textContent = tiempo;

  intervalo = setInterval(() => {
    tiempo--;
    document.getElementById("tiempo").textContent = tiempo;

    if (tiempo === 0) {
      clearInterval(intervalo);
      noRespondidas++;
      actual++;
      mostrarPregunta();
    }
  }, 1000);
}

// responder
function responder(boton, seleccion, correcta) {
  clearInterval(intervalo);

  let botones = document.querySelectorAll("#opciones button");
  botones.forEach(b => b.disabled = true);

  if (seleccion === correcta) {
    boton.classList.add("correcta");
    correctas++;
  } else {
    boton.classList.add("incorrecta");
    incorrectas++;
  }

  setTimeout(() => {
    actual++;
    mostrarPregunta();
  }, 1000);
}

// resultado final
function mostrarResultado() {
  document.getElementById("juego").style.display = "none";

  let div = document.getElementById("resultado");
  div.style.display = "block";

  div.innerHTML = `
    <h2>Resultado</h2>
    <p>Total: 5</p>
    <p>Correctas: ${correctas}</p>
    <p>Incorrectas: ${incorrectas}</p>
    <p>No respondidas: ${noRespondidas}</p>
  `;
}