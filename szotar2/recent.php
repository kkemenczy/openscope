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
<title><?php echo _("Tranlation memory - recent changes");?></title>
<link rel="stylesheet" type="text/css" href="style.css"/>
<script>

function edit(term) {
	window.location.href = "index.php?edit=1&keyword=" + term;
}
</script>
</head>
<body>
<center>

<div id="content">
<h1><?php echo _("Recent changes");?></h1>
<table class="clickable"><tr><th><?php echo _("Date");?></th><th><?php echo _("Term");?></th><th></th><th><?php echo _("Translation");?></th><th><?php echo _("User / IP");?></th></tr>
<?php
$fcontents = file($file_history);
$len = strlen($term);
$result['term'] = $term;
$result['definition'] = $definition;

$class = "light";
$fcontents = array_reverse($fcontents);

$maxItems = 50;
foreach ($fcontents as $line) {
	if ($maxItems-- == 0) break;
        $line = rtrim($line);
	list ($term, $definition, $context, $mdate, $ip) = split("\t", $line);
	$term = htmlentities($term, ENT_QUOTES, 'UTF-8');
	$definition = htmlentities($definition, ENT_QUOTES, 'UTF-8');

	print "<tr class=$class><td class=date onClick=\"edit('" . $term . "')\">$mdate</td>" .
		"<td onClick=\"edit('" . $term . "')\">" . $term . "</td><td>$context</td>" .
		"<td onClick=\"edit('" . $term . "')\">$definition</td><td>$ip</td></tr>";
	$class = ($class == 'light') ? 'dark' : 'light';
}

?>
</table>

<?php
$omitted = count($fcontents) - $maxItems;
printf(ngettext("(%d revision not displayed)","(%d revisions not displayed)",$omitted),$omitted);
?>
<br>
<a href="index.php">&laquo; <?php echo _("Back");?></a>
</div>
</center>

</body>
</html>
