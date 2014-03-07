BitGames
========

Please see the README.MD for an explanation of the purpose of the contained PHP scripts

About BitGames - index.php/index2.php
========

Background:
A friend of mine built a website on Wix (CMS) to host game servers where people could register through
payments with bitcoins. He wanted data about people in his mining pool displayed on the site, but Wix only allows
embedded URLs, HTML, CSS, and JavaScript. Attempting to grab data from an outside URL with JavaScript isn't allowed by
the browser (cross-site scripting) so I needed another way to do it, hence the creation of index.php.

Purpose:
index.php uses PHP Curl to grab the bit miner data from Bitminter as a JSON string (after checking against a
cached copy of the JSON string that's updated every minute to avoid high traffic to the Bitminter server). It then
parsed the JSON string and formatted the returned data into a table. This script was hosted on a free PHP hosting site so
that it could be embedded in the Wix site.

index2.php was meant to accumulate hours every week in a format that was not calculated on the Bitminter server, although
bugs in the script were never fully resolved as the BitGames project eventually died due to a lack of user support.
