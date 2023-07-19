# WHMCS Hooks
Various free hooks for WHMCS.

## List of hooks

- [Fix IntoDNS URLs](#fix-intodns-urls)
- [Prevent spoofing URL for knowledgebase articles](#prevent-spoofing-url-for-knowledgebase-articles)
---
### Fix IntoDNS URLs
IntoDNS removed the DNS records for www.intodns.com. All links to IntoDNS in the WHMCS Admin Area are hardcoded
with the www subdomain.
This hook removes 'www' from the URLs when viewing a client's services or domains.

[🔗 Check the code](hooks/FixIntoDNSURLs.php)
___
### Prevent spoofing URL for knowledgebase articles
As long as you leave the ID for the knowledgebase article in the URL, you can change the URL to whatever you want. 
The following is an example of how the URL can be spoofed:<br>
Original: https://example.com/client/knowledgebase/129/How-do-I-add-another-domain-to-my-webhosting-account.html <br>
Changed URL: https://example.com/client/knowledgebase/129/This-URL-will-stil-work.html

That could potentially be bad for your website's SEO. 

This hook prevents that behaviour and will always redirect back to the original URL.

[🔗 Check the code](hooks/FixKnowledgebaseRedirects.php)
___