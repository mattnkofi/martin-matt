<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Users Vault</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    @font-face {
      font-family: 'Century Gothic';
      src: url('path/to/CenturyGothic.woff2') format('woff2'),
           url('path/to/CenturyGothic.woff') format('woff');
    }

    :root {
      --black: #000;
      --dark-glass: rgba(0, 0, 0, 0.75);
      --white: #fff;
      --red: #E53935;
      --gray: #666;
      --accent: #1E90FF;
    }

    body {
      font-family: 'Century Gothic', 'Poppins', sans-serif;
      background: url('<?php echo base_url(); ?>/cfbg.png') no-repeat center center fixed;
      background-size: cover;
      color: var(--white);
      position: relative;
      min-height: 100vh;
      margin: 0;
      overflow-x: hidden;
    }

    body::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.45);
      z-index: 0;
    }

    h1.system-title {
      font-size: 2.5rem;
      font-weight: 700;
      text-align: center;
      margin-top: 4rem;
      margin-bottom: 1.5rem;
      text-shadow: 0 3px 10px rgba(0, 0, 0, 0.7);
      letter-spacing: 1px;
      position: relative;
      z-index: 2;
    }

    .dashboard-container {
      background: var(--dark-glass);
      border-radius: 1.5rem;
      backdrop-filter: blur(10px);
      padding: 2rem;
      width: 100%;
      max-width: 1100px;
      box-shadow: 0 10px 35px rgba(0, 0, 0, 0.5);
      margin: 0 auto;
      margin-top: 1rem;
      position: relative;
      z-index: 2;
      transition: all 0.4s ease;
    }

    .dashboard-container:hover {
      transform: scale(1.01);
      box-shadow: 0 0 25px rgba(28, 28, 28, 1);
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .search-form {
      display: flex;
      align-items: center;
      background: rgba(255, 255, 255, 0.08);
      border-radius: 0.75rem;
      overflow: hidden;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
      width: 320px;
    }

    .search-form input {
      flex: 1;
      background: transparent;
      border: none;
      padding: 0.7rem 1rem;
      color: var(--white);
      font-size: 1rem;
      outline: none;
    }

    .search-form input::placeholder {
      color: rgba(255, 255, 255, 0.7);
      font-style: italic;
    }

    .search-form button {
      background: var(--black);
      border: none;
      color: var(--white);
      padding: 0.7rem 1rem;
      cursor: pointer;
      transition: 0.3s;
    }

    .search-form button:hover {
      background: var(--accent);
    }

    .create-btn {
      background: #1c1c1cff;
      color: var(--white);
      border: none;
      border-radius: 1rem;
      padding: 0.7rem 1.5rem;
      font-weight: bold;
      display: flex;
      align-items: center;
      cursor: pointer;
      transition: 0.3s;
      text-decoration: none;
    }

    .create-btn:hover {
      background: #434343ff;
      transform: scale(1.02);
      color: #ffffffff;
    }

    .create-btn i {
      margin-right: 8px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }

    th, td {
      padding: 1rem;
      text-align: center;
    }

    th {
      background: rgba(255, 255, 255, 0.08);
      font-weight: bold;
      text-transform: uppercase;
    }

    tr {
      transition: 0.3s;
    }

    tr:nth-child(even) {
      background: rgba(255, 255, 255, 0.04);
    }

    tr:hover td {
      background: rgba(255, 255, 255, 0.12);
      transform: scale(1.01);
      cursor: pointer;
    }

    .btn-action {
      border: none;
      border-radius: 0.5rem;
      padding: 0.5rem 1rem;
      font-weight: 600;
      color: white;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      text-decoration: none;
      transition: 0.3s;
    }

    .btn-update {
      background: #333;
    }

    .btn-update:hover {
      background: #555;
      transform: scale(1.02);
    }

    .btn-delete {
      background: var(--red);
    }

    .btn-delete:hover {
      background: #B71C1C;
      transform: scale(1.02);
    }

    .pagination-container {
      display: flex;
      justify-content: center;
      margin-top: 2rem;
    }

    .pagination li {
      display: inline-block;
      margin: 0 0.3rem;
    }

    .pagination li a {
      background: rgba(255, 255, 255, 0.1);
      color: white;
      padding: 0.6rem 1rem;
      border-radius: 0.75rem;
      text-decoration: none;
      transition: 0.3s;
    }

    .pagination li a:hover,
    .pagination li.active a {
      background: white;
      color: black;
    }

    .footer {
      width: 100%;
      max-width: 1100px;
      display: flex;
      justify-content: flex-end;
      align-items: center;
      margin: 1.5rem auto;
      font-weight: bold;
      font-size: 1.3rem;
      position: relative;
      z-index: 2;
      gap: 0.5rem;
    }

    .footer i {
      margin-right: 8px;
      cursor: pointer;
      transition: 0.3s;
    }

    .footer i:hover {
      color: #ff5555;
      transform: scale(1.2);
    }

    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.6);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 50;
      backdrop-filter: blur(4px);
      opacity: 0;
      pointer-events: none;
      transition: 0.3s ease;
    }

    .modal-overlay.active {
      opacity: 1;
      pointer-events: auto;
    }

    .modal-box {
      background: rgba(30, 30, 30, 0.9);
      border-radius: 1rem;
      padding: 2rem;
      text-align: center;
      box-shadow: 0 0 25px rgba(255, 255, 255, 0.1);
      animation: fadeIn 0.3s ease;
      backdrop-filter: blur(10px);
    }

    @keyframes fadeIn {
      from { transform: scale(0.9); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }

    .modal-box h3 {
      margin-bottom: 1rem;
      font-size: 1.25rem;
      font-weight: 600;
    }

    .modal-buttons {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-top: 1.5rem;
    }

    .modal-buttons button {
      border: none;
      border-radius: 0.75rem;
      padding: 0.7rem 1.5rem;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn-cancel {
      background: var(--gray);
      color: white;
    }

    .btn-cancel:hover {
      background: #555;
      transform: translateY(-2px);
    }

    .btn-logout {
      background: var(--red);
      color: white;
    }

    .btn-logout:hover {
      background: #B71C1C;
      transform: translateY(-2px);
    }
  </style>
</head>

<body>
  <h1 class="system-title">USERS VAULT</h1>

  <div class="dashboard-container">
    <div class="top-bar">
      <form action="<?= site_url('users'); ?>" method="get" class="search-form">
        <?php $q = isset($_GET['q']) ? $_GET['q'] : ''; ?>
        <input name="q" type="text" placeholder="Search..." value="<?= html_escape($q); ?>">
        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>

      <?php if ($logged_in_user['role'] === 'admin'): ?>
        <a href="<?= site_url('users/create'); ?>" class="create-btn">
          <i class="fa-solid fa-circle-plus"></i> Create Account
        </a>
      <?php endif; ?>
    </div>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <?php if ($logged_in_user['role'] === 'admin'): ?>
            <th>Role</th>
            <th>Action</th>
          <?php else: ?>
            <th>Action</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($users)): ?>
          <tr><td colspan="5">No users found</td></tr>
        <?php else: ?>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?= html_escape($user['id']); ?></td>
              <td><?= html_escape($user['username']); ?></td>
              <td><?= html_escape($user['email']); ?></td>
              <?php if ($logged_in_user['role'] === 'admin'): ?>
                <td><?= html_escape(ucfirst($user['role'])); ?></td>
                <td>
                  <a href="<?= site_url('users/update/'.$user['id']); ?>" class="btn-action btn-update">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                  </a>
                  <button class="btn-action btn-delete" onclick="openDeleteModal(<?= $user['id']; ?>)">
                    <i class="fa-solid fa-trash"></i> Delete
                  </button>
                </td>
              <?php else: ?>
                <td>
                  <?php if ($logged_in_user['id'] === $user['id']): ?>
                    <a href="<?= site_url('users/update/'.$user['id']); ?>" class="btn-action btn-update">
                      <i class="fa-solid fa-user"></i> My Profile
                    </a>
                  <?php else: ?>
                    <span class="text-muted"><i class="fa-solid fa-eye-slash"></i> View Only</span>
                  <?php endif; ?>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="pagination-container">
      <ul class="pagination">
        <?= $page; ?>
      </ul>
    </div>
  </div>

  <div class="footer">
    <i class="fa-solid fa-right-from-bracket" id="logout-btn"></i>
    <span><?= html_escape($logged_in_user['username']); ?></span>
  </div>

  <!-- Shared Modal -->
  <div class="modal-overlay" id="action-modal">
    <div class="modal-box">
      <h3 id="modal-text">Are you sure?</h3>
      <div class="modal-buttons">
        <button class="btn-cancel" id="cancel-action">Cancel</button>
        <button class="btn-logout" id="confirm-action">Yes</button>
      </div>
    </div>
  </div>

  <script>
  const modal = document.getElementById("action-modal");
  const modalText = document.getElementById("modal-text");
  const cancelBtn = document.getElementById("cancel-action");
  const confirmBtn = document.getElementById("confirm-action");
  let pendingAction = null;

  // Get logged-in user ID from PHP
  const loggedInUserId = <?= $logged_in_user['id']; ?>;

  // Logout button
  document.getElementById("logout-btn").addEventListener("click", () => {
    modalText.textContent = "Are you sure you want to log out?";
    modal.classList.add("active");
    pendingAction = "logout";
  });

  // Open delete modal
  function openDeleteModal(userId) {
    if (parseInt(userId) === parseInt(loggedInUserId)) {
      modalText.textContent = "You are about to delete your own account. This will log you out. Are you sure?";
    } else {
      modalText.textContent = "Are you sure you want to delete this user?";
    }
    modal.classList.add("active");
    pendingAction = "delete-" + userId;
  }

  // Cancel button
  cancelBtn.addEventListener("click", () => {
    modal.classList.remove("active");
    pendingAction = null;
  });

  confirmBtn.addEventListener("click", () => {
    if (pendingAction === "logout") {
      window.location.href = "<?= site_url('auth/logout'); ?>";
    } else if (pendingAction.startsWith("delete-")) {
      const userId = pendingAction.split("-")[1];
      if (parseInt(userId) === parseInt(loggedInUserId)) {
        window.location.href = "<?= site_url('users/delete/'); ?>" + userId + "?redirect=logout";
      } else {
        window.location.href = "<?= site_url('users/delete/'); ?>" + userId;
      }
    }
  });
</script>

</body>
</html>
