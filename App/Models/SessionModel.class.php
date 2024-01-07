<?php

namespace app\Models;

/**
 * Session wrapper model, handles all session indexing and initializes session
 * @author Václav Škopek
 */
class SessionModel
{

    /**
     * Initializes session with session_start()
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * Sets session $value for given $key
     * @param string $key Key
     * @param mixed $value Value
     * @return void
     */
    public function setValue(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Checks if session has existing $key and returns its value
     * @param string $key Key
     * @return mixed|null data bound to $key | null if there are no data
     */
    public function getValue(string $key): mixed
    {
        if($this->hasKey($key)){
            return $_SESSION[$key];
        }

        return null;
    }

    /**
     * Checks if session has existing $key
     * @param string $key Key
     * @return bool
     */
    public function hasKey(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Unsets $key from session
     * @param string $key Key
     * @return void
     */
    public function removeKey(string $key): void
    {
        if($this->hasKey($key)){
            unset($_SESSION[$key]);
        }
    }

    /**
     * Unsets all variables from session and destroys it
     * @return void
     */
    public function destroy(): void
    {
        session_unset();
        session_destroy();
    }
}