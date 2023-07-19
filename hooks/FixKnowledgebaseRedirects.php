<?php

/**
 * As long as you leave the ID for the knowledgebase article in the URL, you can change the URL to whatever you want.
 * e.g.:
 * Original: https://exampple.com/client/knowledgebase/129/How-do-I-add-another-domain-to-my-webhosting-account.html
 * Changed URL: https://example.com/client/knowledgebase/129/This-URL-will-stil-work.html
 *
 * That could potentially be bad for your website's SEO.
 *
 * This hook prevents that behaviour and will always redirect back to the original URL.
 *
 * @package WHMCS
 * @author Dennis Hermannsen <hej@dennishermannsen.dk>
 */

use WHMCS\Config\Setting;

add_hook('ClientAreaPageKnowledgebase', 1, function ($vars) {
    $routeUriPathMode = Setting::where('setting', 'RouteUriPathMode')->first();
    $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $index = '';
    if($routeUriPathMode->value === 'basic' || $routeUriPathMode->value === 'acceptpathinfo'){
        $index = 'index.php/';
        if($routeUriPathMode->value === 'basic'){
            $index = rtrim($index, '/').'?rp=/';
        }
    }

    $trueURL = $vars['systemsslurl'] . $index . 'knowledgebase/' . ($vars['kbcurrentcat']['id'] ?: $vars['kbarticle']['id']) . '/' . urlencode($vars['kbcurrentcat']['urlfriendlyname'] ?: $vars['kbarticle']['urlfriendlytitle'] . '.html');
    if (($vars['templatefile'] === 'knowledgebasecat' || $vars['templatefile'] === 'knowledgebasearticle') and !str_contains($url, 'search') and !str_contains($url, 'tag')) {
        if ($trueURL !== $url) {
            header('Location: ' . $trueURL);
            exit();
        }
    }
});
