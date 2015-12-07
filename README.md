Twitter embedding extension for Bolt
======================
Allows simple embedding of tweets in content.

Setup
===========
You need to create your API keys on Twitter dev site. 

1. Go to https://apps.twitter.com/app/new and create a new keypair. 
2. Write key and secret in file `app/config/extensions/twitter-embed.pygillier.yml`.

Usage
===========
**Limitation:** Currently, the shortcode can be used only in body part of a page or entry. 

In you content, insert the code `[tweet id=XXX]` or `[tweet url=XXX]` and replace XXX by ID or full url to selected tweet.
When saving the content, your shortcode will be replaced by the actual tweet. 

Issues and support
=================
This extension has flaws, it's my first one !

So, if you find some, don't hesitate to fill an issue here : https://github.com/pygillier/bolt-twitter-embed/issues
