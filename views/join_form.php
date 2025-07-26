<?php
// views/join_form.php
$pageTitle = "Join WorkSafe";
include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php";
?>

<main class="form-container">
  <section class="form-section">
    <h2>Join WorkSafe</h2>
    <p>Fill out the form below to express your interest in our platform.</p>

    <!-- Este es mi formulario. Por ahora no lo voy a enviar a un servidor, solo mostraré un mensaje al enviarlo -->
    <form id="join-form" class="join-form">
      <label for="fullname">Full Name:</label>
      <input type="text" id="fullname" name="fullname" required>

      <label for="phone">Phone Number:</label>
      <input type="tel" id="phone" name="phone" required>

      <label for="email">Email Address:</label>
      <input type="email" id="email" name="email" required>

      <label for="company">Company:</label>
      <input type="text" id="company" name="company">

      <label for="message">Message:</label>
      <textarea id="message" name="message" rows="5" placeholder="Tell us why you're interested..."></textarea>

      <button type="submit" class="btn-primary">Submit</button>

      <!-- Campo oculto, no lo uso aún pero lo dejo por si quiero capturar el número completo con código más adelante -->
      <input type="hidden" name="full_phone" id="full_phone" />
    </form>

    <!-- Este div mostrará la notificación después de enviar -->
    <div id="success-message" style="display:none; margin-top: 15px; color: green; font-weight: bold;">
      Thank you! We've received your information and will contact you shortly.
    </div>
  </section>
</main>

<!-- Añado el script directamente aquí para que se ejecute en esta página -->
<script>
  // Espero a que el documento cargue
  document.addEventListener("DOMContentLoaded", function () {
    // Obtengo el formulario y el mensaje de éxito
    const form = document.getElementById("join-form");
    const successMessage = document.getElementById("success-message");

    // Escucho el evento "submit"
    form.addEventListener("submit", function (e) {
      e.preventDefault(); // Evito que el formulario se envíe (por ahora)

      // Aquí simplemente muestro el mensaje
      successMessage.style.display = "block";

      // También puedo limpiar el formulario si quiero
      form.reset();

      // Y ocultar el mensaje después de unos segundos si lo deseo
      setTimeout(() => {
        successMessage.style.display = "none";
      }, 5000); // 5 segundos
    });
  });
</script>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
