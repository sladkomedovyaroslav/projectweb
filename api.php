<?php

session_start();

require 'db.php';
require 'validator.php';
require 'reservation_service.php';

$pdo = connectDB();

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

$uri = parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH
);

function sendJson($data, $status = 200)
{
    http_response_code($status);

    echo json_encode(
        $data,
        JSON_UNESCAPED_UNICODE
    );

    exit();
}

/*
|--------------------------------------------------------------------------
| POST /api/reservations
|--------------------------------------------------------------------------
*/

if (
    $method === 'POST' &&
    preg_match(
        '#/api/reservations$#',
        $uri
    )
) {

    $data = json_decode(
        file_get_contents(
            'php://input'
        ),
        true
    );

    if (!$data) {

        sendJson(
            [
                'success' => false,
                'message' => 'Некорректный JSON'
            ],
            400
        );
    }

    $errors =
        validateReservation(
            $data
        );

    if (!empty($errors)) {

        sendJson(
            [
                'success' => false,
                'errors' => $errors
            ],
            422
        );
    }

    try {

        $pdo->beginTransaction();

        $result =
            createReservation(
                $pdo,
                $data
            );

        $pdo->commit();

        sendJson([
            'success' => true,

            'login' =>
                $result['login'],

            'password' =>
                $result['password'],

            'profile' =>
                '/profile/' .
                $result['reservation_id']
        ]);

    } catch (Exception $e) {

        $pdo->rollBack();

        sendJson(
            [
                'success' => false,
                'message' =>
                    $e->getMessage()
            ],
            500
        );
    }
}

/*
|--------------------------------------------------------------------------
| PUT /api/reservations/{id}
|--------------------------------------------------------------------------
*/

if (
    $method === 'PUT' &&
    preg_match(
        '#/api/reservations/(\d+)$#',
        $uri,
        $matches
    )
) {

    if (
        empty(
            $_SESSION['user_id']
        )
    ) {

        sendJson(
            [
                'success' => false,
                'message' =>
                    'Требуется авторизация'
            ],
            401
        );
    }

    $reservationId =
        (int)$matches[1];

    $data = json_decode(
        file_get_contents(
            'php://input'
        ),
        true
    );

    $errors =
        validateReservation(
            $data
        );

    if (!empty($errors)) {

        sendJson(
            [
                'success' => false,
                'errors' => $errors
            ],
            422
        );
    }

    try {

        updateReservation(
            $pdo,
            $reservationId,
            $data
        );

        sendJson([
            'success' => true
        ]);

    } catch (Exception $e) {

        sendJson(
            [
                'success' => false,
                'message' =>
                    $e->getMessage()
            ],
            500
        );
    }
}

sendJson(
    [
        'success' => false,
        'message' => 'Route not found'
    ],
    404
);
