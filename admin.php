<?php

require 'db.php';

$pdo = connectDB();

<link rel="stylesheet" href="style.css">

/*
|--------------------------------------------------------------------------
| HTTP AUTH
|--------------------------------------------------------------------------
*/

if (
    !isset(
        $_SERVER['PHP_AUTH_USER']
    )
) {

    header(
        'WWW-Authenticate: Basic realm="Admin Area"'
    );

    header(
        'HTTP/1.0 401 Unauthorized'
    );

    exit(
        'Требуется авторизация'
    );
}

$stmt =
    $pdo->prepare("
        SELECT *
        FROM adminn
        WHERE login = ?
    ");

$stmt->execute([
    $_SERVER['PHP_AUTH_USER']
]);

$admin =
    $stmt->fetch();

if (
    !$admin ||
    !password_verify(
        $_SERVER['PHP_AUTH_PW'],
        $admin['password_hash']
    )
) {

    header(
        'WWW-Authenticate: Basic realm="Admin Area"'
    );

    header(
        'HTTP/1.0 401 Unauthorized'
    );

    exit(
        'Неверный логин или пароль'
    );
}

/*
|--------------------------------------------------------------------------
| DELETE
|--------------------------------------------------------------------------
*/

if (
    !empty(
        $_GET['delete']
    )
) {

    $id =
        (int)$_GET['delete'];

    $stmt =
        $pdo->prepare("
            DELETE
            FROM reservations
            WHERE id = ?
        ");

    $stmt->execute([
        $id
    ]);

    header(
        'Location: admin.php'
    );

    exit();
}

/*
|--------------------------------------------------------------------------
| UPDATE
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD']
    === 'POST'
) {

    $stmt =
        $pdo->prepare("
            UPDATE reservations
            SET
                full_name = ?,
                phone = ?,
                email = ?
            WHERE id = ?
        ");

    $stmt->execute([

        $_POST['full_name'],

        $_POST['phone'],

        $_POST['email'],

        $_POST['id']
    ]);

    header(
        'Location: admin.php'
    );

    exit();
}

/*
|--------------------------------------------------------------------------
| LIST
|--------------------------------------------------------------------------
*/

$reservations =
    $pdo
        ->query("
            SELECT *
            FROM reservations
            ORDER BY id DESC
        ")
        ->fetchAll();

/*
|--------------------------------------------------------------------------
| STATS
|--------------------------------------------------------------------------
*/

$stats =
    $pdo
        ->query("
            SELECT
                tt.name,
                COUNT(
                    rt.reservation_id
                ) AS total

            FROM table_types tt

            LEFT JOIN reservation_tables rt

            ON
            tt.id =
            rt.table_type_id

            GROUP BY tt.id
        ")
        ->fetchAll();

?>

<!DOCTYPE html>
<html lang="ru">
<head>

<meta charset="UTF-8">

<title>

Админка

</title>

</head>
<body>

<h1>

Панель администратора

</h1>

<h2>

Статистика

</h2>

<table border="1">

<tr>

<th>
Тип столика
</th>

<th>
Количество
</th>

</tr>

<?php foreach ($stats as $item): ?>

<tr>

<td>

<?= htmlspecialchars(
    $item['name']
) ?>

</td>

<td>

<?= $item['total'] ?>

</td>

</tr>

<?php endforeach; ?>

</table>

<br>

<h2>

Бронирования

</h2>

<?php foreach (
    $reservations
    as $reservation
): ?>

<form method="POST" class="admin-card">

<input
    type="hidden"
    name="id"
    value="<?= $reservation['id'] ?>"
>

<input
    type="text"
    name="full_name"
    value="<?= htmlspecialchars(
        $reservation['full_name']
    ) ?>"
>

<input
    type="text"
    name="phone"
    value="<?= htmlspecialchars(
        $reservation['phone']
    ) ?>"
>

<input
    type="email"
    name="email"
    value="<?= htmlspecialchars(
        $reservation['email']
    ) ?>"
>

<button type="submit">

Сохранить

</button>

<a
    class="delete-link"
    href="admin.php?delete=<?= $reservation['id'] ?>"
onclick="
return confirm(
'Удалить запись?'
)
"
>

Удалить

</a>

</form>

<hr>

<?php endforeach; ?>

</body>
</html>
