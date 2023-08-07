# WHMCS Hooks
Various free hooks for WHMCS

## Fix IntoDNS URLs
IntoDNS removed the DNS records for www.intodns.com. All links to IntoDNS in the WHMCS Admin Area are hardcoded
with the www subdomain.
This hook removes 'www' from the URLs when viewing a client's services or domains.

[🔗 Check the code](hooks/FixIntoDNSURLs.php)