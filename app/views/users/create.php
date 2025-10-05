<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Student</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    @font-face {
      font-family: 'Century Gothic';
      src: url('<?php echo base_url(); ?>/CenturyGothic.woff2') format('woff2'),
           url('<?php echo base_url(); ?>/CenturyGothic.woff') format('woff');
      font-weight: normal;
      font-style: normal;
    }

    :root {
      --raisin-black: #2D2728ff;
      --van-dyke: #3F3735ff;
      --silver: #C7C2BFff;
      --jet: #383232ff;
      --davys-gray: #5F5957ff;
      --black: #040202ff;
      --smoky-black: #0F0C0Cff;
      --licorice: #1F1A1Aff;
      --raisin-black-2: #282222ff;
      --platinum: #EAE8E5ff;
      --white: #FFFFFFff;
      --error-red: #9B2C2C;
      --error-bg: rgba(155, 44, 44, 0.2);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Century Gothic', sans-serif;
      background: url('<?php echo base_url(); ?>/cfbg.png') no-repeat center center fixed;
      background-size: cover;
      color: var(--silver);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 2rem 1rem;
      position: relative;
      overflow: hidden;
    }

    body::before {
      content: '';
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.45);
      z-index: 0;
    }

    .system-title {
      font-family: 'Century Gothic', sans-serif;
      font-size: 2.7rem;
      font-weight: 700;
      color: var(--platinum);
      text-shadow: 2px 2px 15px rgba(0,0,0,0.8);
      margin-bottom: 1.5rem;
      text-align: center;
      z-index: 10;
    }

    .register-card {
      position: relative;
      z-index: 10;
      background: rgba(20, 20, 20, 0.85);
      border-radius: 1.75rem;
      backdrop-filter: blur(12px);
      padding: 3rem 2.5rem;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.6);
      border: 1px solid rgba(255, 255, 255, 0.1);
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      font-family: 'Century Gothic', sans-serif;
    }

    .register-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 45px rgba(0,0,0,0.65);
    }

    .register-card h2 {
      font-family: 'Century Gothic', sans-serif;
      font-size: 2rem;
      font-weight: 700;
      color: var(--platinum);
      margin-bottom: 2rem;
      border-bottom: 1px solid rgba(255,255,255,0.1);
      padding-bottom: 0.6rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.7rem;
    }

    .register-card h2 i {
      color: var(--silver);
      font-size: 1.4rem;
    }

    .error-box-styled {
      background: var(--error-bg);
      color: var(--error-red);
      padding: 10px;
      border: 1px solid var(--error-red);
      border-radius: 12px;
      margin-bottom: 1.5rem;
      font-size: 0.95em;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      font-family: 'Century Gothic', sans-serif;
    }

    .form-group {
      position: relative;
      margin-bottom: 1.2rem;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 0.8rem 1rem;
      padding-left: 3rem;
      padding-right: 3rem;
      font-size: 1rem;
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 1rem;
      background: rgba(0, 0, 0, 0.07);
      color: var(--platinum);
      transition: 0.3s ease;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      font-family: 'Century Gothic', sans-serif;
    }

    .form-group select {
      background-color: rgba(40, 40, 40, 0.9);
      color: #ffffff;
      border: 1px solid rgba(255,255,255,0.3);
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="%23ffffff" d="M7 10l5 5 5-5z"/></svg>');
      background-repeat: no-repeat;
      background-position: right 1rem center;
    }

    .form-group select option {
      background: #1c1c1c;
      color: #ffffff;
    }

    .form-group input::placeholder {
      color: rgba(255,255,255,0.6);
    }

    .input-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      font-size: 1.1em;
      color: rgba(255,255,255,0.8);
      pointer-events: none;
    }

    .form-group input:focus,
    .form-group select:focus {
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.19);
      background: rgba(0, 0, 0, 1);
    }

    .toggle-password {
      position: absolute;
      right: 1rem;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 1.1em;
      color: rgba(255,255,255,0.7);
      transition: color 0.2s;
    }

    .toggle-password:hover {
      color: #fff;
    }

    .btn-register {
      font-family: 'Century Gothic', sans-serif;
      width: 100%;
      padding: 0.8rem 1.4rem;
      border: none;
      border-radius: 1rem;
      background: #000;
      color: #fff;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 3px 8px rgba(0,0,0,0.5);
      transition: all 0.25s ease;
      margin-top: 1rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .btn-register:hover {
      background: #ffffffff;
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.6);
      color: #000000ff;
    }

    .group-link {
      margin-top: 1.5rem;
      font-size: 0.9em;
      color: rgba(255,255,255,0.7);
      font-family: 'Century Gothic', sans-serif;
    }

    .group-link a {
      color: #fff;
      font-weight: bold;
      text-decoration: underline;
      transition: 0.2s;
    }

    .group-link a:hover {
      color: #aee6ff;
    }

    @media (max-width: 480px) {
      .system-title { font-size: 2.2rem; margin-bottom: 1rem; }
      .register-card { padding: 2rem 1.5rem; border-radius: 1.5rem; }
      .register-card h2 { font-size: 1.8rem; }
    }
  </style>
</head>

<body>
  <h1 class="system-title">USER MAIL REPO VAULTS</h1>
  
  <div class="register-card">
    <h2><i class="fa-solid"></i>Create Account</h2>

    <?php if (!empty($error)): ?>
      <div class="error-box-styled">
        <i class="fa-solid fa-triangle-exclamation"></i> <?= $error ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="<?= site_url('auth/register'); ?>">
  <div class="form-group">
    <i class="fa-solid fa-user input-icon"></i>
    <input type="text" name="username" placeholder="Username" required>
  </div>

  <div class="form-group">
    <i class="fa-solid fa-envelope input-icon"></i>
    <input type="email" name="email" placeholder="Email" required>
  </div>

  <div class="form-group">
    <i class="fa-solid fa-key input-icon"></i>
    <input type="password" id="password" name="password" placeholder="Password" required>
    <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
  </div>

  <div class="form-group">
    <i class="fa-solid fa-lock input-icon"></i>
    <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm Password" required>
    <i class="fa-solid fa-eye toggle-password" id="toggleConfirmPassword"></i>
  </div>

  <div class="form-group">
    <i class="fa-solid fa-user-tag input-icon"></i>
    <select name="role" required>
      <option value="" hidden>Select Role</option>
      <option value="user">User</option>
      <option value="admin">Admin</option>
    </select>
  </div>

  <button type="submit" class="btn-register">
      <i class="fa-solid fa-cloud-arrow-up"></i> Register
  </button>
</form>

<button type="button" class="btn-cancel" style="background: #dc2626; color: #fff; font-weight: bold; padding: 0.75rem; border: none; border-radius: 0.75rem; width: 100%; margin-top: 0.5rem; transition: all 0.3s ease;" onclick="window.location.href='<?= site_url('/users'); ?>'">
  <i class="fa-solid fa-xmark"></i> Cancel
</button>


  <script>
    // toggle visibility
    function toggleVisibility(toggleId, inputId) {
      const toggle = document.getElementById(toggleId);
      const input = document.getElementById(inputId);

      if (toggle && input) {
        toggle.addEventListener('click', function() {
          const type = input.type === 'password' ? 'text' : 'password';
          input.type = type;
          this.classList.toggle('fa-eye');
          this.classList.toggle('fa-eye-slash');
        });
      }
    }
    toggleVisibility('togglePassword', 'password');
    toggleVisibility('toggleConfirmPassword', 'confirmPassword');

    // redirect to users page after successful registration
    <?php if (isset($success) && $success === true): ?>
      window.location.href = "<?= site_url('users'); ?>";
    <?php endif; ?>
  </script>
</body>
</html>
