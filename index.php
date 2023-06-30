<?php
require_once 'db_connect.php';
<<<<<<< HEAD
require_once 'security.php';
=======
>>>>>>> new_branch

session_start();

// Проверка, авторизован ли пользователь
if (isset($_SESSION['user_id'])) {
  // Если пользователь авторизован, перенаправляем на другую страницу в зависимости от его роли
  $role = $_SESSION['role'];
  switch ($role) {
    case 'admin':
      header('Location: admin_dashboard.php');
      break;
    case 'teacher':
      header('Location: teacher_dashboard.php');
      break;
    case 'student':
      header('Location: student_dashboard.php');
      break;
    default:
      // Если у пользователя нет определенной роли, перенаправляем на страницу выхода
      header('Location: logout.php');
      break;
  }
  exit();
}

// Обработка формы входа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

<<<<<<< HEAD
=======
  // Проверка введенных данных

>>>>>>> new_branch
  // Экранирование и очистка данных
  $email = escape($email);
  $password = escape($password);

  // Запрос на получение данных пользователя из базы данных
  $stmt = $mysqli->prepare("SELECT id, role FROM users WHERE email = ? AND status = 'active'");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->bind_result($userId, $userRole);
  $stmt->fetch();
  $stmt->close();

<<<<<<< HEAD
  if ($userId && $userRole) {
=======
  // Если данные верны, авторизуем пользователя и перенаправляем на соответствующую страницу
  if ($userId && $userRole) {
    // Перенаправление на соответствующую страницу
>>>>>>> new_branch
    $_SESSION['user_id'] = $userId;
    $_SESSION['role'] = $userRole;
    switch ($userRole) {
      case 'admin':
        header('Location: admin_dashboard.php');
        break;
      case 'teacher':
        header('Location: teacher_dashboard.php');
        break;
      case 'student':
        header('Location: student_dashboard.php');
        break;
      default:
<<<<<<< HEAD
=======
        // Если у пользователя нет определенной роли, перенаправляем на страницу выхода
>>>>>>> new_branch
        header('Location: logout.php');
        break;
    }
    exit();
  } else {
<<<<<<< HEAD
=======
    // Обработка случая, когда введенные данные не соответствуют записям в базе данных
    // Вывод ошибки или другие действия по вашему усмотрению
>>>>>>> new_branch
    echo "Неправильный email или пароль.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Главная страница</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <div class="container">
    <h1>Добро пожаловать на сайт!</h1>
    <p>Здесь можно ввести описание вашего сайта.</p>
    <div class="login-form">
      <h2>Войти</h2>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="email" name="email" placeholder="Электронная почта" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
      </form>
      <p>Нет аккаунта? <a href="registration.php">Зарегистрироваться</a></p>
    </div>
  </div>
</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> new_branch
