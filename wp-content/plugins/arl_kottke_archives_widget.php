<?php
/*
Plugin Name: Kottke Style Archive Widget
Version: 0.3.0.1
Plugin URI: http://www.lattimore.id.au/projects/wordpress/plugins/kottke-style-archives/
Author: Alistair Lattimore
Author URI: http://www.lattimore.id.au
Description: Displays an archive of posts in the same style to http://www.kottke.org/everfresh.
*/

function arl_kottke_archives($month_separator = '.', $month_format = 'm')
{
	global $wpdb;
	$output = "";
	$year = "";

	$sql = "SELECT DATE_FORMAT(post_date, '%Y') AS Year, ";
	$sql .= "DATE_FORMAT(post_date, '%m') AS Month ";
	$sql .= "FROM $wpdb->posts ";
	$sql .= "WHERE DATE_FORMAT(post_date, '%Y') <> '0000'";
	$sql .= " AND post_status = 'publish'";
	$sql .= " AND post_type = 'post' ";
	$sql .= "GROUP BY DATE_FORMAT(post_date, '%Y'), DATE_FORMAT(post_date, '%m') ";
	$sql .= "ORDER BY DATE_FORMAT(post_date, '%Y') DESC, DATE_FORMAT(post_date, '%m') ASC;";

	$months = $wpdb->get_results($sql);

	if (!empty($months))
	{
		foreach ($months as $month)
		{
			// Add in the year heading
			if (($year == "") || ($year != $month->Year))
			{
				if (strlen($output))
				{
					$output .= "<br />\n<strong>" . $month->Year . ":</strong>&nbsp;";
				}
				else
				{
					$output .= "\n<strong>" . $month->Year . ":</strong>&nbsp;";
				}
			}

			// Add in the monthly archive links
			if ($year == $month->Year)
				$output .= $month_separator;

			$output .= '<a href="' . get_month_link($month->Year, $month->Month) . '">' . date($month_format, mktime(0, 0, 0, $month->Month, 1, $month->Year)) . '</a>';

			$year = $month->Year;
		}
	}
	else
	{
		$output = "<p>Nem érhető el</p>\n";
	}

	print $output;
}

function widget_kottke_archive($args) {

  extract($args);
  echo $before_widget;
  echo $before_title;?>Archívum<?php echo $after_title;?>
  <div><?php
  arl_kottke_archives();?>
  </div><?php
  echo $after_widget;
}

 
function KottkeArchive_init()
{
  register_sidebar_widget(__('Kottke Archives'), 'widget_kottke_archive');
}
add_action("plugins_loaded", "KottkeArchive_init");
?>