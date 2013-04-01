<?php
require_once ('config.inc.php');

putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain("tm", $localedir);
textdomain("tm");

header("Content-Type: text/html; charset=UTF-8");

?>
<html>
<head>
<title><?php echo _("Translation memory - Changelog");?></title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>

<div id="content">
<h1>Changelog</h1>
<pre>
<?php
include ('ChangeLog');
?>
</pre>
<br>
<a href="index.php">&laquo; <?php echo _("Back");?></a>
</div>

</body>
</html>
