<?php

session_start();

require 'db.php';

$pdo = connectDB();

$error = '';

if (
    $_SERVER['REQUEST_METHOD']
    === 'POST'
) {

    $stmt =
        $pdo->prepare("
            SELECT *
            FROM users
            WHERE login = ?
        ");

    $stmt->execute([
        $_POST['login']
    ]);

    $user =
        $stmt->fetch();

    if (
        $user &&
        password_verify(
            $_POST['password'],
            $user['password_hash']
        )
    ) {

        $_SESSION['user_id'] =
            $user['id'];

        header(
            'Location: index.php'
        );

        exit();
    }

    $error =
        'Неверный логин или пароль';
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>

<meta charset="UTF-8">

<title>
Авторизация
</title>

</head>
<body>

<h1>
Вход
</h1>

<?php if ($error): ?>

<p>

<?= htmlspecialchars($error) ?>

</p>

<?php endif; ?>

<form method="POST">

<input
    type="text"
    name="login"
    placeholder="Логин"
>

<br><br>

<input
    type="password"
    name="password"
    placeholder="Пароль"
>

<br><br>

<button type="submit">

Войти

</button>

</form>

</body>
</html>
