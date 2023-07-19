<?php

/**
 * Forces users to login before accessing any page in WHMCS.
 *
 * @package WHMCS
 * @author Dennis Hermannsen <hej@dennishermannsen.dk>
 */

use WHMCS\Authentication\CurrentUser;
use WHMCS\Config\Setting;

add_hook('ClientAreaPage', 1, function ($vars) {
    $user = new CurrentUser;
    $templateFile = $vars['templatefile'];
    if(!$user->isAuthenticatedUser() and !$user->isAuthenticatedAdmin() and !in_array($templateFile, ['login', 'dologin', 'password-reset-container', 'register', 'clientarea']))
    {
        $systemURL = Setting::where('setting', 'SystemURL')->first();
        $systemURL = $systemURL->value;
        if(!str_ends_with($systemURL, '/')){
            $systemURL = $systemURL.'/';
        }
        header("Location: {$systemURL}login.php");
        exit();
    }
});