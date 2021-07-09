 $( function() {
    $( "#grupoTablas" ).tabs();
  } );
  function myFunction() {
    var x = document.getElementById("formulario_create");
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }
}