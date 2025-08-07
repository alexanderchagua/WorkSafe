<?php
// views/join_form.php
$pageTitle = "Join WorkSafe";
include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php";
?>

<main class="form-container">
  <section class="form-section">
    <h2>Join WorkSafe</h2>
    <p>Fill out the form below to express your interest in our platform.</p>

  
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

  
      <input type="hidden" name="full_phone" id="full_phone" />
    </form>

 
    <div id="success-message" style="display:none; margin-top: 15px; color: green; font-weight: bold;">
      Thank you! We've received your information and will contact you shortly.
    </div>
  </section>
</main>


<script>

  document.addEventListener("DOMContentLoaded", function () {
  
    const form = document.getElementById("join-form");
    const successMessage = document.getElementById("success-message");


    form.addEventListener("submit", function (e) {
      e.preventDefault(); 

  
      successMessage.style.display = "block";

   
      form.reset();

   
      setTimeout(() => {
        successMessage.style.display = "none";
      }, 5000); 
    });
  });
</script>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
