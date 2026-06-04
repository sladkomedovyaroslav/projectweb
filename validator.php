<?php

function validateReservation(array $data)
{
    $errors = [];

    if (
        empty($data['full_name']) ||
        !preg_match(
            '/^[а-яА-Яa-zA-Z\s\-]+$/u',
            $data['full_name']
        )
    ) {
        $errors['full_name'] =
            'Введите корректное имя';
    }

    if (
        empty($data['phone']) ||
        !preg_match(
            '/^[0-9+\-\s()]+$/',
            $data['phone']
        )
    ) {
        $errors['phone'] =
            'Некорректный телефон';
    }

    if (
        empty($data['email']) ||
        !filter_var(
            $data['email'],
            FILTER_VALIDATE_EMAIL
        )
    ) {
        $errors['email'] =
            'Некорректный email';
    }

    if (empty($data['reservation_date'])) {

        $errors['reservation_date'] =
            'Укажите дату';
    }

    if (
        empty($data['guests_count']) ||
        $data['guests_count'] < 1
    ) {
        $errors['guests_count'] =
            'Укажите количество гостей';
    }

    if (empty($data['table_types'])) {

        $errors['table_types'] =
            'Выберите тип столика';
    }

    return $errors;
}
