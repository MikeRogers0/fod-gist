=== Gist Shortcode === 

Provides Gist embed shortcode. It also caches the gist.

If you have any questions or feedback, I'm <a href="http://twitter.com/MikeRogers0">@MikeRogers0</a> on twitter.

== Usage: ==
To embed a gist, do below but replace the id with the one from the url.
`[gist id="1751763" /]`

To embed a file from a gist do this:
`[gist id="1751763" file="somefile.js" /]`

If you want to stop it from caching a gist, use the nocache attribute:
`[gist id="1751763" nocache="true" /]`

== Changelog ==

= 1.2.0 =

* Made it so unpublished posts aren't cached.
* Added in a readme for the Wordpress site.

= 1.1.0 =

* Added in a noscript of the gist.