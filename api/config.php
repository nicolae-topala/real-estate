<?php
class Config{
    const DATE_FORMAT = "Y-m-d H:i:s";

    public static function DB_HOST(){
        return Config::get_env("DB_HOST", "localhost");
    }
    public static function DB_USERNAME(){
        return Config::get_env("DB_USERNAME", "real-estate");
    }
    public static function DB_PASSWORD(){
        return Config::get_env("DB_PASSWORD", "123321");
    }
    public static function DB_SCHEME(){
        return Config::get_env("DB_SCHEME", "real-estate");
    }
    public static function DB_PORT(){
        return Config::get_env("DB_PORT", "3306");
    }

    public static function SMTP_HOST(){
        return Config::get_env("SMTP_HOST", "smtp.gmail.com");
    }
    public static function SMTP_PORT(){
        return Config::get_env("SMTP_PORT", "587");
    }
    public static function SMTP_USER(){
        return Config::get_env("SMTP_USER", "real.estate.project.ibu@gmail.com");
    }
    public static function SMTP_PASS(){
        return Config::get_env("SMTP_PASS", "dumyexiodehnypay");
    }
// CDN config
    public static function CDN_KEY(){
        return Config::get_env("CDN_KEY", "F5A3CXUKXVYXCRNBZ2ZX");
    }
    public static function CDN_SECRET(){
        return Config::get_env("CDN_SECRET", "+xkJKwb1KwJGkMqJBOEDPUoH2v2z8qBheQ/5D7XQ6fA");
    }
    public static function CDN_SPACE(){
        return Config::get_env("CDN_SPACE", "cdn.real-estate.live");
    }
    public static function CDN_BASE_URL(){
        return Config::get_env("CDN_BASE_URL", "https://fra1.digitaloceanspaces.com");
    }
    public static function CDN_REGION(){
        return Config::get_env("CDN_REGION", "fra1");
    }

    const JWT_SECRET ="!IgzGraHsaoWSPc1Orm^u8*pS0sgKQ";
    const JWT_TOKEN_TIME= 604800;

    public static function get_env($name, $default){
        return isset($_ENV[$name]) && trim($_ENV[$name]) != '' ? $_ENV[$name] : $default;
    }
}
