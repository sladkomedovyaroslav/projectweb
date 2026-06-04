<!DOCTYPE html>
<html lang="ru">
<head>

<meta charset="UTF-8">

<title>
Ресторан
</title>

<link
    rel="stylesheet"
    href="style.css"
>

</head>

<body>

<div class="container">

<h1>
Бронирование столика
</h1>

<form
    id="reservationForm"
    method="POST"
>

<label>
ФИО
</label>

<input
    type="text"
    name="full_name"
>

<label>
Телефон
</label>

<input
    type="text"
    name="phone"
>

<label>
Email
</label>

<input
    type="email"
    name="email"
>

<label>
Дата бронирования
</label>

<input
    type="date"
    name="reservation_date"
>

<label>
Количество гостей
</label>

<input
    type="number"
    name="guests_count"
    min="1"
>

<label>
Типы столиков
</label>

<select
    name="table_types[]"
    multiple
>

<?php foreach (
    $tableTypes
    as $table
): ?>

<option
    value="<?= $table['id'] ?>"
>

<?= htmlspecialchars(
    $table['name']
) ?>

</option>

<?php endforeach; ?>

</select>

<label>
Комментарий
</label>

<textarea
    name="comment"
></textarea>

<button
    type="submit"
>
Забронировать
</button>

</form>

<br>

<a href="login.php">
Вход
</a>

<br><br>

<a href="admin.php">
Админка
</a>

</div>

<script
    src="js/reservation.js"
></script>

</body>
</html>
