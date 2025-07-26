// Espero a que el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", function () {
  // Selecciono el formulario usando la clase que ya tiene
  const form = document.querySelector(".join-form");

  // Selecciono el div que mostrará la notificación
  const notification = document.querySelector("#notification");

  // Añado un 'listener' para cuando se envíe el formulario
  form.addEventListener("submit", function (e) {
    e.preventDefault(); // Evito que se recargue la página o se envíe por defecto

    // Muestro el mensaje
    notification.style.display = "block";

    // Luego de 4 segundos oculto el mensaje y limpio el formulario
    setTimeout(() => {
      notification.style.display = "none";
      form.reset(); // Esto limpia los campos del formulario
    }, 4000);
  });
});
