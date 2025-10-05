<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Account</title>

  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  <style>
    @font-face {
      font-family: 'Century Gothic';
      src: url('path/to/CenturyGothic.woff2') format('woff2'),
           url('path/to/CenturyGothic.woff') format('woff');
    }

    body {
      font-family: 'Century Gothic', 'Poppins', sans-serif;
      background: url('<?php echo base_url(); ?>/cfbg.png') no-repeat center center fixed;
      background-size: cover;
      color: white;
      position: relative;
      min-height: 100vh;
      overflow: hidden;
    }

    body::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.45);
      z-index: 0;
    }

    .content-wrapper {
      position: relative;
      z-index: 10;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 1.5rem;
    }

    .login-card {
      background: rgba(20, 20, 20, 0.85);
      border-radius: 1.25rem;
      padding: 2rem 2.5rem;
      max-width: 380px;
      width: 100%;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
      border: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(6px);
      z-index: 10;
    }

    h1.system-title {
      font-weight: 700;
      text-align: center;
      letter-spacing: 1px;
      font-size: 3rem;
      margin-bottom: 3rem;
      margin-top: -5rem;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.8);
    }

    .login-card h2 {
      text-align: center;
      font-weight: 600;
      font-size: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .form-group {
      position: relative;
      display: flex;
      align-items: center;
      background: rgba(255, 255, 255, 0.07);
      border-radius: 0.75rem;
      padding: 0.75rem 1rem;
      margin-bottom: 1rem;
    }

    .input-icon {
      color: rgba(255, 255, 255, 0.8);
      font-size: 1rem;
      margin-right: 0.5rem;
    }

    .form-group input {
      flex: 1;
      background: transparent;
      border: none;
      outline: none;
      color: #fff;
      font-size: 0.95rem;
    }

    .form-group input::placeholder {
      color: rgba(255, 255, 255, 0.6);
      font-style: italic;
    }

    .toggle-password {
      color: rgba(255, 255, 255, 0.6);
      cursor: pointer;
      font-size: 1rem;
      margin-left: 0.5rem;
    }

    .btn-login {
      background: #000;
      color: #fff;
      font-weight: bold;
      padding: 0.75rem;
      border: none;
      border-radius: 0.75rem;
      width: 100%;
      margin-top: 0.5rem;
      transition: all 0.3s ease;
    }

    .btn-login:hover {
      background: #ffffffff;
      transform: translateY(-3px);
      color: #000000
    }

    .error-box-styled {
      background: rgba(255, 0, 0, 0.12);
      border-left: 3px solid #ff4d4d;
      color: #ffb3b3;
      padding: 0.75rem 1rem;
      border-radius: 0.5rem;
      margin-bottom: 1rem;
      font-size: 0.9rem;
      text-align: center;
    }

    .group-link {
      text-align: center;
      margin-top: 1rem;
      font-size: 0.8rem;
      color: rgba(255, 255, 255, 0.7);
    }

    .group-link a {
      color: #fff;
      font-weight: 600;
      text-decoration: underline;
    }

    .group-link a:hover {
      color: #aee6ff;
    }

    @media (max-width: 640px) {
      .login-card {
        padding: 1.5rem;
      }
      h1.system-title {
        font-size: 1.6rem;
      }
    }
  </style>
</head>

<body>
  <div class="content-wrapper">
    <h1 class="system-title">USER MAIL REPO VAULT</h1>

    <div class="login-card">
      <h2>Login</h2>

      <?php if (!empty($error)): ?>
        <div class="error-box-styled">
          <i class="fa-solid fa-triangle-exclamation"></i> <?= $error ?>
        </div>
      <?php endif; ?>

      <form method="post" action="<?= site_url('auth/login') ?>">
        <div class="form-group">
          <i class="fa-solid fa-user input-icon"></i>
          <input type="text" placeholder="Username" name="username" required>
        </div>

        <div class="form-group">
          <i class="fa-solid fa-key input-icon"></i>
          <input type="password" placeholder="Password" name="password" id="password" required>
          <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
        </div>

        <button type="submit" class="btn-login">Continue</button>
      </form>

<div class="group-link">
  Don’t have an account yet? <a href="<?= site_url('auth/register'); ?>"><i class="fa-solid fa-user-plus"></i> Register here</a>
</div>

  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', () => {
      const type = password.type === 'password' ? 'text' : 'password';
      password.type = type;
      togglePassword.classList.toggle('fa-eye');
      togglePassword.classList.toggle('fa-eye-slash');
    });
  </script>
</body>
</html>
