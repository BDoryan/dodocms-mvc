<?php

Autoloader::require('core/classes/i18n/Internationalization.php');

class Session
{

    public static function start(): void
    {
        if (self::isStarted()) return;
        session_start();
    }

    public static function isStarted(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Return true if the user is authenticated
     *
     * @return bool
     * @throws Exception
     */
    public static function authenticated(): bool
    {
        if (!self::isStarted()) return false;
        if (self::getAdminSession() == null) return false;
        return true;
    }

    /**
     * @throws Exception
     */
    public static function getAdminSession(): ?AdminUserSessionModel
    {
        $token = $_SESSION['dodocms_admin_session'] ?? ($_COOKIE["dodocms_admin_token"] ?? null);
        if ($token === null) return null;

        $jwtManager = Application::get()->getJwtManager();
        if ($jwtManager->verifyToken($token) === null) return null;

        // TODO: It's not a good idea to query the database every time we need the session
        $sessions = AdminUserSessionModel::findAll('*', ['token' => $token]);
        if (empty($sessions)) return null;

        return $sessions[0];
    }

    /**
     * Check if a user session is set
     *
     * @return bool
     */
    public static function hasAdminSession(): bool
    {
        return isset($_SESSION['dodocms_admin_session']);
    }

    /**
     * @throws Exception
     */
    public static function getAdminUser(): ?AdminUserModel
    {
        $session = self::getAdminSession();
        if ($session === null) return null;

        if (Cache::get("user") === null)
            Cache::set("user", $session->getUser());

        return Cache::get("user");
    }

    public static function setAdminSession(AdminUserSessionModel $session)
    {
        $_SESSION['dodocms_admin_session'] = $session->getToken();
    }

    public static function setAdminToken(string $token, int $duration)
    {
        setcookie("dodocms_admin_token", $token, time() + $duration, "/");
    }

    public static function hasAdminToken(): bool
    {
        return isset($_COOKIE["dodocms_admin_token"]);
    }

    public static function removeAdminToken()
    {
        setcookie("dodocms_admin_token", "", time() - 3600, "/");
    }

    public static function getTokenSession(): ?string
    {
        return $_COOKIE["dodocms_admin_token"] ?? null;
    }

    public static function removeAdminSession()
    {
        unset($_SESSION['dodocms_admin_session']);
    }

    public static function removeAdminAccess() {
        self::removeAdminSession();
        self::removeAdminToken();
    }

    public static function setLanguage(string $lang): void
    {
        $_SESSION["language"] = $lang;
    }

    public static function getLanguage(): ?string
    {
        return self::get("language");
    }

    public static function get(string $key)
    {
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];
        return null;
    }

    public static function remove(string $key): void
    {
        if (isset($_SESSION[$key]))
            unset($_SESSION[$key]);
    }

    public static function destroy(): void
    {
        if (!self::isStarted()) return;
        session_destroy();
    }
}