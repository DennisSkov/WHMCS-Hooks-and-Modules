<?php

/**
 * As long as you leave the ID for the knowledgebase or announcement article in the URL, you can change the URL to whatever you want.
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

function forceRedirect($vars, $page): void
{
    $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $routeUriPathMode = Setting::where('setting', 'RouteUriPathMode')->first();
    $index = '';
    if($routeUriPathMode->value === 'basic' || $routeUriPathMode->value === 'acceptpathinfo'){
        $index = 'index.php/';
        if($routeUriPathMode->value === 'basic'){
            $index = rtrim($index, '/').'?rp=/';
        }
    }

    $id = '';
    $friendlyName = '';

    if($vars['kbarticle']['id']){
        $id = $vars['kbarticle']['id'];
        $friendlyName = $vars['kbarticle']['urlfriendlytitle'].'.html';
    }elseif($vars['kbcurrentcat']['id']){
        $id = $vars['kbcurrentcat']['id'];
        $friendlyName = $vars['kbcurrentcat']['urlfriendlyname'];
    }elseif(isset($vars['id'])){
        $id = $vars['id'];
        $friendlyName = $vars['urlfriendlytitle'].'.html';
    }

    $trueURL = $vars['systemsslurl'] . $index . $page . '/' . $id . '/' . $friendlyName;
    if($trueURL !== $url and $id !== ''){
        header('Location: ' . $trueURL);
        exit();
    }
}

add_hook('ClientAreaPageKnowledgebase', 1, function ($vars) {forceRedirect($vars, 'knowledgebase');});
add_hook('ClientAreaPageAnnouncements', 1, function ($vars) {forceRedirect($vars, 'announcements');});
