<?php

namespace app\Models;

class SessionModel
{

    public function __construct()
    {
        session_start();
    }

    public function setValue(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function getValue(string $key){
        if($this->hasKey($key)){
            return $_SESSION[$key];
        }

        return null;
    }

    public function hasKey(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function removeKey(string $key): void
    {
        if($this->hasKey($key)){
            unset($_SESSION[$key]);
        }
    }

    public function destroy(): void
    {
        session_unset();
        session_destroy();
    }
}