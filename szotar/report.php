<?php
require_once ('config.inc.php');

putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain("tm", $localedir);
textdomain("tm");

header("Content-Type: text/html; charset=UTF-8");
$term_unfixed = 0;
$term_fixed = 0;
$term_unsorted = 0;
$term_type = _("unfixed");

if (isset($_GET['type'])) {
    if ($_GET['type'] == 'unsorted' ){
        $term_type = _("unsorted");
        $term_unsorted = "1";
    } elseif ($_GET['type'] == 'fixed' ){
        $term_type = _("fixed");
        $term_fixed = 1;

    } else {
        $term_type = _("unfixed");
        $term_unfixed = 1;
    }

} else {
    $term_unfixed = 1;
}

$lines = file($file_glossary);

$fcontents = array();
foreach ($lines as $line_num => $line) {
    if ($term_unfixed && strstr($line,'?')) {
        array_push($fcontents,$line);
    } elseif ($term_fixed && strstr($line,'!')) {
        array_push($fcontents,$line);
    } elseif ($term_unsorted && !strstr($line,'?') && !strstr($line,'!')) {
        array_push($fcontents,$line);
    }
}

?>
<html>
<head>
<title><?php printf(_("Translation memory - Report for %s terms"), $term_type);?></title>
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
<h1><?php printf(_("Report for %s"), $term_type); ?></h1>
<table class="clickable"><tr><th><?php echo _("Term");?></th><th><?php echo _("Context");?></th><th><?php echo _("Translation");?></th></tr>
<?php
$class = "light";


foreach ($fcontents as $line) {
    $line = rtrim($line);
	list ($term, $definition, $context) = explode("\t", $line);
	$term = htmlentities($term, ENT_QUOTES, 'UTF-8');
	$definition = htmlentities($definition, ENT_QUOTES, 'UTF-8');

	print "<tr class=$class>" .
		"<td onClick=\"edit('" . $term . "')\">" . $term . "</td><td>$context</td>" .
		"<td onClick=\"edit('" . $term . "')\">$definition</td></tr>";
	$class = ($class == 'light') ? 'dark' : 'light';
}

?>
</table>

<?php
$lines_count = count($fcontents);
/*Translator: %s is one of fixed, unfixed*/
printf (ngettext("%d %s term", "%d %s terms", $lines_count), $lines_count, $term_type);
?>
<br>
<a href="index.php">&laquo; <?php echo _("Back");?></a>
</div>
</center>

</body>
</html>
