<?php

namespace DatabaseConnection;

use Config\ConfigLoader;

class DatabaseConfig extends ConfigLoader
{
    protected const FILE_NAME = '.database.env';

    public const HOST = "HOST";
    public const PORT = "PORT";
    public const DB_NAME = "DB_NAME";
    public const USER = "USER";
    public const PASSWORD = "PASSWORD";

    protected const CONFIG_KEYS = [
        self::HOST,
        self::PORT,
        self::DB_NAME,
        self::USER,
        self::PASSWORD,
    ];
}