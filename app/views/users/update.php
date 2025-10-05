<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Update User Profile</title>

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
      --white: #FFFFFFff;
      --silver: #C7C2BFff;
      --platinum: #EAE8E5ff;
      --dark-glass: rgba(0,0,0,0.75);
      --accent: #1E90FF;
      --error-red: #9B2C2C;
      --error-bg: rgba(155,44,44,0.2);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Century Gothic', sans-serif;
      background: url('<?= base_url(); ?>/cfbg.png') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      position: relative;
      overflow: hidden;
      color: var(--silver);
    }

    body::before {
      content: '';
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.45);
      z-index: 0;
    }

    .system-title {
      font-size: 3rem;
      font-weight: 700;
      color: var(--platinum);
      text-shadow: 2px 2px 15px rgba(0,0,0,0.8);
      margin-bottom: 1.5rem;
      text-align: center;
      z-index: 10;
    }

    .form-card {
      position: relative;
      z-index: 10;
      background: var(--dark-glass);
      border-radius: 1.75rem;
      backdrop-filter: blur(12px);
      padding: 3rem 2.5rem;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.6);
      border: 1px solid rgba(255,255,255,0.1);
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .form-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 45px rgba(0,0,0,0.65);
    }

    .form-card h2 {
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

    .form-card h2 i {
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
      background: rgba(0,0,0,0.07);
      color: var(--platinum);
      transition: 0.3s ease;
      font-family: 'Century Gothic', sans-serif;
    }

    .form-group select {
        -webkit-appearance: none; 
        -moz-appearance: none;    
        appearance: none;        
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

    .form-group select {
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="%23C7C2BF" d="M7 10l5 5 5-5z"/></svg>');
      background-repeat: no-repeat;
      background-position: right 1rem center;
    }

    .form-group input:focus,
    .form-group select:focus {
      box-shadow: 0 0 10px rgba(255,255,255,0.19);
      background: rgba(0,0,0,1);
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

    .btn-submit,
    .btn-return {
      display: block;
      width: 220px; 
      padding: 0.8rem 2rem;
      margin: 1rem auto 0;
      border-radius: 1rem;
      text-align: center;
      font-size: 1.1rem;
      font-weight: bold;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      transition: 0.3s;
    }

    .btn-submit {
      background: rgba(255,255,255,0.15);
      color: #fff;
      border: none;
      box-shadow: 0 3px 8px rgba(0,0,0,0.5);
    }

    .btn-submit:hover {
      background: #fff;
      color: #000;
      transform: scale(1.02);
      box-shadow: 0 5px 15px rgba(0,0,0,0.6);
    }

    .btn-return {
      background: rgba(216, 0, 0, 1);
      color: #fff;
      text-decoration: none;
      border-radius: 1rem;
    }

    .btn-return:hover {
      background: rgba(117, 0, 0, 1);
    }

    @media (max-width: 480px) {
      .system-title { font-size: 2.2rem; margin-bottom: 1rem; }
      .form-card { padding: 2rem 1.5rem; border-radius: 1.5rem; }
      .form-card h2 { font-size: 1.8rem; }
      .btn-submit, .btn-return { width: 200px; padding: 0.7rem 1.8rem; }
    }
  </style>
</head>
<body>
  <h1 class="system-title">USER MAIL REPO VAULT</h1>

  <div class="form-card">
    <h2><i class="fa-solid fa-pen-to-square"></i> Update User Info</h2>

    <div id="js-error-box" class="error-box-styled" style="display:none;">
      <i class="fa-solid fa-triangle-exclamation"></i> <span id="js-error-text"></span>
    </div>

    <?php if (!empty($error)): ?>
      <div class="error-box-styled">
        <i class="fa-solid fa-triangle-exclamation"></i> <?= $error ?>
      </div>
    <?php endif; ?>

    <!-- SINGLE FORM -->
    <form id="updateForm" action="<?= site_url('users/update/'.$user['id']) ?>" method="POST">
      <div class="form-group">
        <i class="fa-solid fa-user input-icon"></i>
        <input type="text" name="username" value="<?= html_escape($user['username']); ?>" placeholder="Username" required>
      </div>

      <div class="form-group">
        <i class="fa-solid fa-envelope input-icon"></i>
        <input type="email" name="email" value="<?= html_escape($user['email']); ?>" placeholder="Email" required>
      </div>

      <div class="form-group">
        <i class="fa-solid fa-key input-icon"></i>
        <input type="password" name="password" id="password" placeholder="New Password (leave blank to keep current password)">
        <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
      </div>

      <?php if(!empty($logged_in_user) && $logged_in_user['role'] === 'admin'): ?>
      <div class="form-group">
        <i class="fa-solid fa-user-tag input-icon"></i>
        <select name="role" required>
          <option value="user" <?= $user['role']==='user'?'selected':''; ?>>User</option>
          <option value="admin" <?= $user['role']==='admin'?'selected':''; ?>>Admin</option>
        </select>
      </div>
      <?php endif; ?>

      <button type="submit" class="btn-submit">
        <i class="fa-solid fa-cloud-arrow-up"></i> Save Changes
      </button>
    </form>

    <a href="<?= site_url('/users'); ?>" class="btn-return">
      <i class="fa-solid fa-arrow-left"></i> Cancel
    </a>
  </div>

  <script>
    // Toggle password visibility
    document.getElementById("togglePassword")?.addEventListener("click", function() {
      const pwd = document.getElementById("password");
      const type = pwd.type === "password" ? "text" : "password";
      pwd.type = type;
      this.classList.toggle("fa-eye-slash");
    });

    // Detect unchanged fields
    const form = document.getElementById("updateForm");
    const jsErrorBox = document.getElementById("js-error-box");
    const jsErrorText = document.getElementById("js-error-text");

    const originalData = {
      username: "<?= html_escape($user['username']); ?>",
      email: "<?= html_escape($user['email']); ?>",
      password: ""
    };

    form.addEventListener("submit", function(e) {
      const username = form.username.value.trim();
      const email = form.email.value.trim();
      const password = form.password ? form.password.value : "";

      if (username === originalData.username &&
          email === originalData.email &&
          password === "") {
        e.preventDefault();
        jsErrorText.textContent = "No changes detected! Please modify some fields before saving.";
        jsErrorBox.style.display = "flex";
      } else {
        jsErrorBox.style.display = "none";
      }
    });
  </script>
</body>
</html>
