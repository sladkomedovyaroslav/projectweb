<?php

function connectDB()
{
    return new PDO(
        'mysql:host=localhost;dbname=u68592;charset=utf8mb4',
        'u68592',
        '1511698',
        [
            PDO::ATTR_ERRMODE =>
                PDO::ERRMODE_EXCEPTION,

            PDO::ATTR_DEFAULT_FETCH_MODE =>
                PDO::FETCH_ASSOC
        ]
    );
}
