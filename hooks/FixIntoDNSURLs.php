<?php

/**
 * Fix IntoDNS URLs in the WHMCS Admin Area.
 *
 * @package WHMCS
 * @author Dennis Hermannsen <hej@dennishermannsen.dk>
 */

add_hook('AdminAreaFooterOutput', 1, function($vars) {
    $filename = $vars['filename'];
    $pages = ['clientsservices', 'clientsdomains'];
    $html = '';
    if(in_array($filename, $pages)){
        $html = <<<HTML
        <script type='text/javascript'>
            document.body.innerHTML = document.body.innerHTML.replace(/www\.intodns\.com/g, 'intodns\.com'); 
        </script>
        HTML;
    }
    return $html;
});