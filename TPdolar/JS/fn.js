async function convertir(){
    try {
        
        let valor = document.getElementById("pesos").value;
        let error = document.getElementById("error");
        let respuesta = document.getElementById("resultado");

        error.innerHTML="";
        respuesta.innerHTML="";
        
        if((valor === "")  || (isNaN(valor))){
            error.innerHTML= "ERROR. No has ingresado un numero";
            return;
        }

        let pesos = parseFloat(valor);//convierte en decimales 

        const response = await fetch("https://dolarapi.com/v1/dolares");
        const data = await response.json();

        let oficial= data.find(d => d.nombre === "Oficial");
        let blue= data.find(d => d.nombre === "Blue");
        let mep= data.find(d => d.nombre === "Bolsa");

        mostrarResultados(pesos,oficial,blue,mep);


    } catch (e) {
        document.getElementById("error").innerHTML = "ERROR con la API";

    }
}

function mostrarResultados(pesos,oficial,blue,mep){

    document.getElementById("resultado").innerHTML = `
    <div class="tarjeta">
        <h2>OFICIAL</h2><br>
        Compra:$${oficial.compra}-> USD ${(pesos/oficial.compra).toFixed(2)} <br><br>
        Venta:$${oficial.venta}-> USD ${(pesos/oficial.venta).toFixed(2)} <br><br>
    </div>
    <div class="tarjeta">
        <h2>BLUE</h2><br>
        Compra:$${blue.compra}-> USD ${(pesos/blue.compra).toFixed(2)} <br><br>
        Venta:$${blue.venta}-> USD ${(pesos/blue.venta).toFixed(2)} <br><br>
    </div>
    <div class="tarjeta">
        <h2>MEP</h2><br>
        Compra:$${mep.compra}-> USD ${(pesos/mep.compra).toFixed(2)} <br><br>
        Venta:$${mep.venta}-> USD ${(pesos/mep.venta).toFixed(2)} <br><br>
    </div>  `;
                                                                     
}
