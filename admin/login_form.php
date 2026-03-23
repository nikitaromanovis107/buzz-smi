<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Вход в админку</title>
  <style>
    body {
      background: #f8f8f8;
      font-family: sans-serif;
      padding: 2rem;
    }
    .login-box {
      max-width: 400px;
      margin: 5rem auto;
      background: white;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h2 {
      margin-bottom: 1.5rem;
      color: #333;
    }
    input[type="password"] {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 1rem;
      margin-bottom: 1rem;
    }
    button {
      background: #000;
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 4px;
      font-weight: bold;
      cursor: pointer;
    }
    .error {
      color: #e74c3c;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Админ-панель — вход</h2>
    <?php if (isset($_GET['error'])): ?>
      <div class="error">Неверный пароль!</div>
    <?php endif; ?>
    <form method="POST" action="login.php">
      <input type="password" name="password" placeholder="Пароль" required>
      <button type="submit">Войти</button>
    </form>
  </div>
</body>
</html>