<?php

function createReservation(
    PDO $pdo,
    array $data
)
{
    $login =
        'user_' . time();

    $password =
        bin2hex(
            random_bytes(4)
        );

    $passwordHash =
        password_hash(
            $password,
            PASSWORD_DEFAULT
        );

    $stmt = $pdo->prepare("
        INSERT INTO users
        (
            login,
            password_hash
        )
        VALUES (?, ?)
    ");

    $stmt->execute([
        $login,
        $passwordHash
    ]);

    $userId =
        $pdo->lastInsertId();

    $stmt = $pdo->prepare("
        INSERT INTO reservations
        (
            user_id,
            full_name,
            phone,
            email,
            reservation_date,
            guests_count,
            comment
        )
        VALUES
        (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $userId,
        $data['full_name'],
        $data['phone'],
        $data['email'],
        $data['reservation_date'],
        $data['guests_count'],
        $data['comment']
    ]);

    $reservationId =
        $pdo->lastInsertId();

    $stmt = $pdo->prepare("
        INSERT INTO reservation_tables
        (
            reservation_id,
            table_type_id
        )
        VALUES (?, ?)
    ");

    foreach (
        $data['table_types']
        as $tableType
    ) {

        $stmt->execute([
            $reservationId,
            $tableType
        ]);
    }

    return [
        'login' => $login,
        'password' => $password,
        'reservation_id' =>
            $reservationId
    ];
}

function updateReservation(
    PDO $pdo,
    int $reservationId,
    array $data
)
{
    $stmt = $pdo->prepare("
        UPDATE reservations
        SET
            full_name = ?,
            phone = ?,
            email = ?,
            reservation_date = ?,
            guests_count = ?,
            comment = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $data['full_name'],
        $data['phone'],
        $data['email'],
        $data['reservation_date'],
        $data['guests_count'],
        $data['comment'],
        $reservationId
    ]);

    $stmt = $pdo->prepare("
        DELETE FROM reservation_tables
        WHERE reservation_id = ?
    ");

    $stmt->execute([
        $reservationId
    ]);

    $stmt = $pdo->prepare("
        INSERT INTO reservation_tables
        (
            reservation_id,
            table_type_id
        )
        VALUES (?, ?)
    ");

    foreach (
        $data['table_types']
        as $tableType
    ) {

        $stmt->execute([
            $reservationId,
            $tableType
        ]);
    }
}
