<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login_form.php');
    exit;
}
include 'includes/db.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    header('Location: dashboard.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    die('Статья не найдена');
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Редактировать статью</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>

  <!-- HEADER -->
  <header class="site-header">
    <div class="header-container">
      <div class="logo">
        <a href="../index.php">BUZZ</a>
      </div>
      <a href="logout.php" class="admin-logout">Выйти</a>
    </div>
  </header>

  <!-- КОНТЕНТ -->
  <main class="admin-page">
    <div class="container">
      <h1 class="page-title">РЕДАКТИРОВАТЬ СТАТЬЮ</h1>

      <section class="admin-section">
        <form method="POST" action="update_article.php" class="admin-form" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= (int)$article['id'] ?>">

          <input type="text" name="title" value="<?= htmlspecialchars($article['title']) ?>" required placeholder="Заголовок статьи">
          
          <input type="text" name="category" value="<?= htmlspecialchars($article['category']) ?>" required placeholder="Категория">
          
          <input type="text" name="author" value="<?= htmlspecialchars($article['author']) ?>" required placeholder="Автор">
          
          <input type="text" name="excerpt" value="<?= htmlspecialchars($article['excerpt']) ?>" required placeholder="Краткое описание">
          
          <textarea name="full_text" placeholder="Полный текст статьи" required><?= htmlspecialchars($article['full_text']) ?></textarea>
          
          <div>
            <label>Текущее изображение:</label><br>
            <img src="<?= htmlspecialchars($article['img']) ?>" alt="Изображение" style="max-width:200px; max-height:150px; margin:10px 0;">
          </div>
          
          <div>
            <label>Заменить изображение (опционально):</label><br>
            <input type="file" name="image" accept="image/*">
          </div>

          <button type="submit" class="btn-primary">ОБНОВИТЬ СТАТЬЮ</button>
        </form>

        <div style="margin-top: 20px;">
          <a href="dashboard.php" class="btn-secondary">← Назад к странице администратора</a>
        </div>
      </section>
    </div>
  </main>

</body>
</html>