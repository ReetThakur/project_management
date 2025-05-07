<?php

namespace App\Traits;

trait NotificationTrait
{
    protected function successMessage($message, $route = null, $params = [])
    {
        if ($route) {
            return redirect()->route($route, $params)->with('success', $message);
        }
        return redirect()->back()->with('success', $message);
    }

    protected function errorMessage($message, $route = null, $params = [])
    {
        if ($route) {
            return redirect()->route($route, $params)->with('error', $message);
        }
        return redirect()->back()->with('error', $message);
    }

    protected function warningMessage($message, $route = null, $params = [])
    {
        if ($route) {
            return redirect()->route($route, $params)->with('warning', $message);
        }
        return redirect()->back()->with('warning', $message);
    }

    protected function infoMessage($message, $route = null, $params = [])
    {
        if ($route) {
            return redirect()->route($route, $params)->with('info', $message);
        }
        return redirect()->back()->with('info', $message);
    }
} 