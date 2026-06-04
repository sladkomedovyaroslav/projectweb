<!DOCTYPE html>

<html lang="ru">
<head>

<meta charset="UTF-8">

<title>
Restaurant Elegance
</title>

<link
    rel="stylesheet"
    href="style.css"
>

</head>

<body>

<div class="hero">

```
<div class="hero-content">

    <h1>
        Restaurant Elegance
    </h1>

    <p>
        Авторская кухня • Премиальный сервис • Незабываемая атмосфера
    </p>

</div>
```

</div>

<div class="container">

```
<h2 class="section-title">
    Добро пожаловать
</h2>

<div class="features">

    <div class="feature">

        <h3>
            🍷 Авторская кухня
        </h3>

        <p>
            Уникальные блюда от шеф-повара из свежайших ингредиентов.
        </p>

    </div>

    <div class="feature">

        <h3>
            🌆 Уютный интерьер
        </h3>

        <p>
            Идеальное место для романтического ужина и деловых встреч.
        </p>

    </div>

    <div class="feature">

        <h3>
            ⭐ Высокий сервис
        </h3>

        <p>
            Мы заботимся о каждом госте и создаем особенную атмосферу.
        </p>

    </div>

</div>

<h2 class="section-title">
    Забронировать столик
</h2>

<form
    id="reservationForm"
    method="POST"
>

    <label>
        Ваше имя
    </label>

    <input
        type="text"
        name="full_name"
        placeholder="Введите имя"
        required
    >

    <label>
        Телефон
    </label>

    <input
        type="text"
        name="phone"
        placeholder="+7 (999) 999-99-99"
        required
    >

    <label>
        Email
    </label>

    <input
        type="email"
        name="email"
        placeholder="example@mail.ru"
        required
    >

    <label>
        Дата бронирования
    </label>

    <input
        type="date"
        name="reservation_date"
        required
    >

    <label>
        Количество гостей
    </label>

    <input
        type="number"
        name="guests_count"
        min="1"
        max="20"
        required
    >

    <label>
        Выберите тип столика
    </label>

    <select
        name="table_types[]"
        multiple
        required
    >

        <?php foreach ($tableTypes as $table): ?>

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
        placeholder="Ваши пожелания..."
    ></textarea>

    <button type="submit">

        Забронировать столик

    </button>

</form>

<div class="links">

    <a href="login.php">
        Личный кабинет
    </a>

    |

    <a href="admin.php">
        Администрирование
    </a>

</div>
```

</div>

<script src="js/reservation.js"></script>

</body>
</html>
