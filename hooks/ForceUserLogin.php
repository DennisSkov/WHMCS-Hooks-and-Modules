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
    $excludedTemplateFiles = ['login', 'dologin', 'password-reset-container', 'register', 'clientarea', 'user-invite-accept'];
    if(!$user->isAuthenticatedUser() and !$user->isAuthenticatedAdmin() and !in_array($templateFile, $excludedTemplateFiles))
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