<?php
session_start();

// Подключение к базе данных
require_once 'db_connect.php';
require_once 'security.php';

// Проверка роли пользователя
if (!checkUserRole('student')) {
    redirectToLogin();
}

// Получение данных студента
$student_id = $_SESSION['user_id'];
$query = "SELECT full_name FROM users WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $student_id);
$stmt->execute();
$stmt->bind_result($student_name);
$stmt->fetch();
$stmt->close();

// Получение расписания предметов студента
$query = "SELECT subjects.id AS subject_id, subjects.name AS subject_name, student_schedule.subject_status 
          FROM subjects
          LEFT JOIN student_schedule ON subjects.id = student_schedule.subject_id AND student_schedule.student_id = ?
          ORDER BY subjects.name";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $student_id);
$stmt->execute();
$result = $stmt->get_result();
$schedule = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title><?php echo escapeHTML('Страница студента'); ?></title>
</head>
<body>
<div class="container">
    <h1>Добро пожаловать, <?php echo escapeHTML($student_name); ?></h1>

    <h2>Расписание предметов</h2>
    <div class="table-container">
        <table>
            <tr>
                <th>Название предмета</th>
                <th>Статус</th>
                <th>Выбрать предмет</th>
            </tr>
            <?php foreach ($schedule as $subject) : ?>
                <tr>
                    <td><?php echo escapeHTML($subject['subject_name']); ?></td>
                    <td><?php echo escapeHTML($subject['subject_status']); ?></td>
                    <td>
                        <?php if ($subject['subject_status'] !== 'active') : ?>
                            <form method="post" action="student_dashboard.php">
                                <input type="hidden" name="subject_selection" value="<?php echo escapeHTML($subject['subject_id']); ?>">
                                <input type="submit" value="Выбрать">
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="logout-form">
        <form method="post" action="logout.php">
            <input type="submit" value="Выход из кабинета">
        </form>
    </div>
</div>
</body>
</html>