<?php
class Config
{
    const DATA_FORMAT = "Y-m-d H:i:s";

    public static function DB_HOST()
    {
        return Config::get_env("DB_HOST", "localhost");
    }

    public static function DB_USERNAME()
    {
        return Config::get_env("DB_USERNAME", "carmarket");
    }

    public static function DB_PASSWORD()
    {
        return Config::get_env("DB_PASSWORD", "123321");
    }

    public static function DB_SCHEME()
    {
        return Config::get_env("DB_SCHEME", "carmarket");
    }

    public static function DB_PORT()
    {
        return Config::get_env("DB_PORT", "3307");
    }

    public static function SMTP_HOST()
    {
        return Config::get_env("SMTP_HOST", "smtp.gmail.com");
    }

    public static function SMTP_PORT()
    {
        return Config::get_env("SMTP_PORT", "587");
    }

    public static function SMTP_USER()
    {
        return Config::get_env("SMTP_USER", "car.market.noreply@gmail.com");
    }

    public static function SMTP_PASSWORD()
    {
        return Config::get_env("SMTP_PASSWORD", "nptnyevozkjosmcc");
    }

    const JWT_SECRET = "?8JwAt8>&M3JYX}nky+=*N#V,pbW9Tz.";
    const JWT_TOKEN_TIME = 604800;

    public static function get_env($name, $default)
    {
        return isset($_ENV[$name]) && trim($_ENV[$name]) != '' ? $_ENV[$name] : $default;
    }
}
