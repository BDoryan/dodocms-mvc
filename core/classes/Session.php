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
        if (self::getUserSession() == null) return false;
        return true;
    }

    /**
     * @throws Exception
     */
    public static function getUserSession(): ?UserSessionModel
    {
        $token = $_SESSION['user_session'] ?? null;
        if ($token === null) return null;

        $jwtManager = Application::get()->getJwtManager();
        if ($jwtManager->verifyToken($token) === null) return null;

        $sessions = UserSessionModel::findAll('*', ['token' => $token]);
        if (empty($sessions)) return null;

        return $sessions[0];
    }

    /**
     * Check if a user session is set
     *
     * @return bool
     */
    public static function hasUserSession(): bool {
        return isset($_SESSION['user_session']);
    }

    /**
     * @throws Exception
     */
    public static function getUser(): ?UserModel
    {
        $session = self::getUserSession();
        if ($session === null) return null;
        return $session->getUser();
    }

    public static function setUserSession(UserSessionModel $session)
    {
        $_SESSION['user_session'] = $session->getToken();
    }

    public static function removeUserSession()
    {
        unset($_SESSION['user_session']);
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