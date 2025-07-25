<?php
// views/join_form.php
$pageTitle = "Join WorkSafe";
include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php";
?>

<main class="form-container">
  <section class="form-section">
    <h2>Join WorkSafe</h2>
    <p>Fill out the form below to express your interest in our platform.</p>
    <form action="#" method="post" class="join-form">
      <label for="fullname">Full Name:</label>
      <input type="text" id="fullname" name="fullname" required>

      <label for="email">Email Address:</label>
      <input type="email" id="email" name="email" required>

      <label for="company">Company:</label>
      <input type="text" id="company" name="company">

      <label for="message">Message:</label>
      <textarea id="message" name="message" rows="5" placeholder="Tell us why you're interested..."></textarea>

      <button type="submit" class="btn-primary">Submit</button>
    </form>
  </section>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
