=== Sched Embed ===
Contributors: cftp, johnbillion, simonwheatley
Tags: sched, sched.org, embed, shortcode
Requires at least: 3.4
Tested up to: 3.5
Stable tag: trunk
License: GPL v2 or later

Embed event content from sched.org into your WordPress site.

== Description ==

This plugin allows you to quickly swap between user accounts in WordPress at the click of a button. You'll be instantly logged out and logged in as your desired user. This is handy for test environments where you regularly log out and in between different accounts, or for adminstrators of sites who need to switch between multiple accounts.

== Installation ==

You can install this plugin directly from your WordPress dashboard:

 1. Go to the *Plugins* menu and click *Add New*.
 2. Search for *Sched Embed*.
 3. Click *Install Now* next to the *Sched Embed* plugin.
 4. Activate the plugin.

Alternatively, see the guide to [Manually Installing Plugins](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

= Usage =

Embed content from your sched.org event by adding the following shortcode to your post or page content:

`[sched url="example.sched.org"]`

Replace `example.sched.org` with the URL of your own event. By default, the event schedule will be embedded. See the FAQ for how to embed a list of attendees, sponsors, speakers or exhibitors.

== Frequently Asked Questions ==

= What can I embed with this shortcode? =

You can embed any of the following views using the `view` attribute:

**Schedule (Default View)**

`[sched url="example.sched.org" view="schedule"]` or just `[sched url="example.sched.org"]`

**Schedule: Expanded**

`[sched url="example.sched.org" view="expanded"]`

**Schedule: Grid**

`[sched url="example.sched.org" view="grid"]`

**Schedule: By Venue**

`[sched url="example.sched.org" view="venues"]`

**Attendees**

`[sched url="example.sched.org" view="attendees"]`

**Speakers**

`[sched url="example.sched.org" view="speakers"]`

**Sponsors**

`[sched url="example.sched.org" view="sponsors"]`

**Exhibitors**

`[sched url="example.sched.org" view="exhibitors"]`

= Can I specify the width of the embed? =

You can specify the width of the embed using the `width` attribute:

`[sched url="example.sched.org" width="500"]`

Note that sched.org only supports widths of 500, 600, 700, 800 and 900 (pixels). The default width is 990 pixels.

= Can I hide the sidebar in the embed? =

You can hide the sidebar in the embed by setting the `sidebar` attribute to 'no':

`[sched url="example.sched.org" sidebar="no"]`

= Can I improve the colour scheme for use on a dark background colour? =

You can specify a colour scheme which is suitable for use on a dark background by setting the `background` attribute to 'dark':

`[sched url="example.sched.org" background="dark"]`

= Can I specify the fallback text? =

You can specify the fallback text which will be shown to users who have JavaScript disabled:

`[sched url="example.sched.org"]View my event on sched.org[/sched]`

If you don't specify this, the title of the event page will be used.

== Screenshots ==

1. The *Switch To* link on the Users screen
2. The *Switch To* link on a user's profile

== Upgrade Notice ==

= 1.0 =
* Initial release.

== Changelog ==

= 1.0 =
* Initial release.
