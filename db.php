<?php

function connectDB()
{
    return new PDO(
        'mysql:host=localhost;dbname=u82683;charset=utf8mb4',
        'u82683',
        '1511698',
        [
            PDO::ATTR_ERRMODE =>
                PDO::ERRMODE_EXCEPTION,

            PDO::ATTR_DEFAULT_FETCH_MODE =>
                PDO::FETCH_ASSOC
        ]
    );
}
