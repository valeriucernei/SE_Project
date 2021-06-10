<?php
/**
 * Config class
 *
 */
class Config {
    const DATA_FORMAT = "Y-m-d H:i:s";

    /* Data Base Settings */
    public static function DB_HOST() {
        return Config::get_env("DB_HOST", "localhost");
    }

    public static function DB_USERNAME() {
        return Config::get_env("DB_USERNAME", "carmarket");
    }

    public static function DB_PASSWORD() {
        return Config::get_env("DB_PASSWORD", "123321");
    }

    public static function DB_SCHEME() {
        return Config::get_env("DB_SCHEME", "carmarket");
    }

    public static function DB_PORT() {
        return Config::get_env("DB_PORT", "3307");
    }

    /* Gmail SMTP Email Server Settings */
    public static function SMTP_HOST() {
        return Config::get_env("SMTP_HOST", "smtp.gmail.com");
    }

    public static function SMTP_PORT() {
        return Config::get_env("SMTP_PORT", "587");
    }

    public static function SMTP_USER() {
        return Config::get_env("SMTP_USER", "car.market.noreply@gmail.com");
    }

    public static function SMTP_PASSWORD() {
        return Config::get_env("SMTP_PASSWORD", "nptnyevozkjosmcc");
    }

    /*Digital Ocean Spaces CDN Settings*/
    public static function CDN_KEY() {
        return Config::get_env("CDN_KEY", "CLXDZS24AL6KDVDGCG33");
    }

    public static function CDN_SECRET() {
        return Config::get_env("CDN_SECRET", "9al/BuSCGmdkK8DZMh5sk5ooJLYnbXJGbiV/kVSoaSY");
    }

    public static function CDN_SPACE() {
        return Config::get_env("CDN_SPACE", "cdn.car-market.live");
    }

    public static function CDN_BASE_URL() {
        return Config::get_env("CDN_BASE_URL", "https://fra1.digitaloceanspaces.com");
    }

    public static function CDN_REGION() {
        return Config::get_env("CDN_REGION", "fra1");
    }

    const JWT_SECRET = "?8JwAt8>&M3JYX}nky+=*N#V,pbW9Tz.";
    const JWT_TOKEN_TIME = 604800;

    public static function get_env($name, $default) {
        return isset($_ENV[$name]) && trim($_ENV[$name]) != '' ? $_ENV[$name] : $default;
    }
}
