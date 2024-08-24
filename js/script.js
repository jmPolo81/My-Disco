/* Función del menú desplegable */

var coll = document.getElementsByClassName("colapsable");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("activo");
    var contenido = this.nextElementSibling;
    if (contenido.style.maxHeight){
      contenido.style.maxHeight = null;
    } else {
      contenido.style.maxHeight = contenido.scrollHeight + "px";
    }
  });
}

