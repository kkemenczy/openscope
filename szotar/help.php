<?php
header("Content-Type: text/html; charset=UTF-8");
function path() {
    $basePath = explode('/',$_SERVER['SCRIPT_NAME']);
    $script = array_pop($basePath);
    $basePath = implode('/',$basePath);
    if ( isset($_SERVER['HTTPS']) ) {
        $scheme = 'https';
    } else {
        $scheme = 'http';
    }
    echo $scheme.'://'.$_SERVER['SERVER_NAME'].$basePath;
}
?>
<html>
<head>

<title>Fordítási segédszótár - súgó oldal</title>
<style>
body, td, th { font-family: arial; font-size: 13px; }
#content { width:400px; text-align:left }
h1 { color: #aaa; font-weight: normal; font-size: 26px; text-align: center}
h2 { color: #aaa; font-weight: normal; font-size: 18px; margin-bottom: 5px}
ul { margin-top: 1px }
table { background: #ccc }
td { background: #eee; padding: 3px; font-size: 12px;}
a, a:visited { color: #00a }
</style>

</head>
<body>
<center>
<div id="content">

<h1>Fordítási segédszótár - súgó oldal</h1>

Ezt a szótárat „szabad” és „nyílt forrású” szoftverek fordításához használják magyar fordítócsapatok.
Mindenki közreműködhet, a rendszert a <a href="http://wiki.org/wiki.cgi?WhatIsWiki">Wiki</a> ötletén
alapul. (minden változtatás mentésre kerül).
<p>
Az oldal működéséhez JavaScript támogatás szükséges.

<h2>Nyers adatok letöltése</h2>
A tartalom licence <a
href="http://www.gnu.org/copyleft/gpl.html">GPL</a> és innen letölthető: <a
href="data/glosar.txt">glosar.txt</a>.



<h2>Magyar fordítócsapatok</h2>
<a href="http://gnome.hu">GNOME</a>,
<a href="https://launchpad.ubuntu.com/~ubuntu-l10n-hu">Ubuntu</a>

<h2>Forráskód</h2>
A forráskód licence <a
href="http://www.gnu.org/copyleft/gpl.html">GPL</a>, a legfrissebb változat letölthető <a
href="https://code.launchpad.net/~ubuntu-l10n-hu/ubuntu-hu-web/glossary">innen</a>.

<hr noshade size=1>
</div>
<a href="index.php">&laquo; Vissza</a>
</center>
</body>
</html>
