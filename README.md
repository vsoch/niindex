# Niindex

Nifti indexing for web servers. A [demo](http://www.vbmis.com/bmi/project/niindex) is available.

#### Overview
This duo of scripts will transform a web server to automatically render a viewer, [neurosynth](http://www.neurosynth.org) decoding, and social media sharing (Twitter) for any folder (or subfolder) of your web server directory. Your server (or you) must allow for both directory indexing and configuration of said directory indexing for this to work (a standard for most web servers).

#### Setup 1: Subdirectory and Recursive Subdirectories

1. Drop the .niindex.php into the base of your server. This will not change any permissions or behavior, this is simply the location that the `.htaccess` (discussed below) expects to find it.

2. Place the `.htaccess` in any subfolder on your server, and this will enable niindex for that directory and all directories below it.


#### Setup 2: Single Directory

In the case that you want to limit niindex to only serve one folder, simply change this line in .htaccess:

      DirectoryIndex /.niindex.php

to

      DirectoryIndex .niindex.php

and place the `niindex.php` along with the `.htaccess` in your directory of choice. 
