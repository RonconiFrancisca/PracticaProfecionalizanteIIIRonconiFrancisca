class Carta{
    constructor(emoji){
        this.emoji = emoji;
        this.visible = false;
        this.resuelta = false;
    }
}

class Juego{
    constructor(){
        this.tablero = document.getElementById("tablero");
        this.mensaje = document.getElementById("mensaje");
        this.cartas = [];
        this.seleccionadas = [];
        this.bloqueado = false;
        this.tiempo = 0;
        this.intervalo = null;
        this.juegoIniciado = false;
        this.intentos = 0;
        this.tablero.style.display = "none";

        this.iniciar();
    }

    iniciarJuego(){
        this.tiempo = 0;
        this.juegoIniciado = true;
        this.mensaje.textContent = "";
        this.intentos = 0;
        document.getElementById("intentos").textContent = "Intentos: 0";

        this.tablero.style.display = "grid";
        clearInterval(this.intervalo);

        this.intervalo = setInterval(() => {
            this.tiempo++;
            document.getElementById("tiempo").textContent = "Tiempo: " + this.tiempo + " s";
        }, 1000);

        this.iniciar();
    }

    iniciar(){
        const emojis = this.generarEmojis();
        this.cartas = this.mezclar([...emojis, ...emojis]).map( e => new Carta(e));

        this.render()

    }

    generarEmojis(){
        const lista = [
            "😎","🤩","🥳","😴","🤯","🥶","🥵","😈","👻","🐶",
            "🐱","🐭","🐰","🦊","🐻","🐼","🐨","🐯", "🍌","🍇",
            "🍓","🍕","🍔","🍟","🌮","🍩","🍪", "⚽","🏀","🏈",
            "🎮","🎲","🎸","🎧","🚗","✈️","🚀","💡","📚","🔑",
            "💎","🎁", "🌵","🌴","🌳","🌲","🍀","🌸","🌼","🍎"  
            ];
        return lista;
    }

    mezclar(array){
        return array.sort(() => Math.random() - 0.5);
    }

    render(){
        this.tablero.innerHTML = "";

        this.cartas.forEach((carta, index) => {
            
            const div = document.createElement("div");
            div.classList.add("carta");

            if(carta.visible || carta.resuelta){
                div.classList.add("visible");
                div.textContent = carta.emoji;
            }

            if( carta.resuelta){
                div.classList.add("resuelta");
            }

            div.addEventListener("click", () => this.seleccionarCarta(index));

            this.tablero.appendChild(div);
        })

    }

    seleccionarCarta(index){
        if (!this.juegoIniciado) return;
        const carta = this.cartas[index];

        if (this.bloqueado || carta.visible || carta.resuelta) {
            return;
        }

        carta.visible = true;
        this.seleccionadas.push(carta);

        this.render();

        if(this.seleccionadas.length === 2){
            this.verificar();
        }
    }

    verificar(){
        this.bloqueado = true;

        const [c1, c2] = this.seleccionadas;
        this.intentos++;
        document.getElementById("intentos").textContent = "Intentos: " + this.intentos; 
        if(c1.emoji === c2.emoji){
            c1.resuelta = true;
            c2.resuelta = true;

            this.resetTurno();

        }else { 
            setTimeout(() => {
                c1.visible = false;
                c2.visible = false;

                this.resetTurno();
            }, 1000);

        }
    }

    resetTurno(){
        this.seleccionadas = [];
        this.bloqueado = false;
        this.render();
        this.verificarFin();
    
    }

    verificarFin(){
        if(this.cartas.every(c => c.resuelta)){
            clearInterval(this.intervalo);
            this.juegoIniciado = false;

            const mejorTiempo = localStorage.getItem("mejorTiempo");
            const mejoresIntentos = localStorage.getItem("mejoresIntentos");

            let nuevoRecord = false;

            if(!mejorTiempo || this.tiempo < Number(mejorTiempo)){
                localStorage.setItem("mejorTiempo", this.tiempo);
                localStorage.setItem("mejoresIntentos", this.intentos);
                nuevoRecord = true;
            }

            const tiempoRecord = localStorage.getItem("mejorTiempo");
            const intentosRecord = localStorage.getItem("mejoresIntentos");

            this.mensaje.textContent = nuevoRecord 
            ? "¡Nuevo récord!"
            : "Juego terminado";
       
            document.getElementById("record").innerHTML = `
            <strong>Resultado de esta partida:</strong><br>
            Tiempo: ${this.tiempo}s <br>
            Intentos: ${this.intentos} <br><br>

            <strong>Mejores marcas:</strong><br>
            Mejor tiempo: ${tiempoRecord}s <br>
            Menos intentos: ${intentosRecord}`;
        }
    }
}
const juego = new Juego();

document.getElementById("btnIniciar").addEventListener("click", () => {
    juego.iniciarJuego();
});
