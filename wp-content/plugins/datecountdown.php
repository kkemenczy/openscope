<?php

/*
Plugin Name: Peter's Date Countdown
Plugin URI: http://www.theblog.ca
Description: Display a countdown of important dates. Use it with or without widgets.
Version: 2.0.0
Author: Peter Keung
Author URI: http://www.theblog.ca/date-countdown
Change Log:
2008-08-25  Combined widget and non-widget version into one plugin.
2007-07-29  Added some fine-grained translation settings, another option for displaying items that have arrived in the JavaScript countdown, and some compatibility for quotes and apostrophes in text fields.
2007-07-02  Increased the maximum length of the fields for countdown items (to accommodate for long links and the like). Also tweaked the JavaScript countdown so that it can be customized to say "x more sleeps/days/winks" just like the normal countdown.
2007-06-17  The JavaScript countdown now has 3 options for when the event has arrived: stop count at 0, continue counting into negative numbers, or show the "text when finished".
2007-03-24  Added smarter URL generation to enhance compatibility with different server setups.

See the plugin URL for a full history of changes
*/

// Change this if you want to add or subtract hours from your server time
$timediff = 0;

// Change this to equal "true" for JavaScript countdown mode. This overrides the following three settings, as it will automatically show hours and minutes
$pdc_java = false;

// Change this to equal "true" if you want the countdown to display the number of hours remaining when there is less than one day remaining
$showhours = false;

// Change this to equal "true" if you want the countdown to display the number of minutes remaining when there is less than one hour remaining
$showminutes = false;

// For the non-JavaScript version, change this to equal "true" to show the time since an event has happened, instead of showing the "text when finished". In this case, set the "text when finished" to be typically the same as the name of the event.
$pdc_showsince = false;

// Change this to equal the maximum number of countdowns to display at once. For an unlimited number of countdowns, make it equal 0
$numcountdowns = 0;

// If you are using the JavaScript countdown, this option will dictate what happens when the countdown ends
// Set this to equal 0 to make it display the "text when finished"
// Set this to equal 1 to make it simply stop at 0
// Set this to equal 2 to make the countdown continue in negative numbers
// Set this to equal 3 to make the countdown continue but display positive numbers and time "since" instead of "until"
$pdc_javaend = 0;

// Change this to be the path to the datecountdown folder in the plugins directory (should work as this by default)
$datecount_path = "wp-content/plugins/peters-date-countdown/";

// This setting is to customize who has access to the Manage Countdowns page in the admin panel
// To allow only administrators access, set this to 9. A level of 7 will typically allow "editors" access as well
// See http://codex.wordpress.org/User_Levels for full documentation on the different user levels
$pdc_userlevel = 9;

// Leave this as "false" unless the countdown isn't displaying on your sub-pages. In that case, enter your site address, which should be the same as the WordPress address from your Options page. Enter it in quotes like the commented line below, withOUT a trailing slash.
// $pdc_siteurl = "http://yoursiteaddress/whatever";
$pdc_siteurl = false;

// Leave this as "false" unless you have an open_basedir restriction on your server and can't get it removed. In that case, enter the server path to your blog (different from the site address!) like in the example below WITH a trailing slash.
// $pdc_abspath = "/home/yourusername/public_html/blog/";
$pdc_abspath = false;

// ------------------------------------------------------
// Language settings

// Name of the sidebar header if you are using the plugin as a widget
$pdc_widget_header = 'Countdowns';

$pdc_text = array(); // do not edit this line
// Set this to the text that should appear before the time remaining. Add a space after it, such as "Only "
$pdc_text['before'] = "";

// Set this to the text that should display after the time remaining but before the unit (typically "more " as in "10 more minutes"). Add a space after it.
$pdc_text['more'] = "more ";

// Set this to the text that should display after the time when the event has not yet occurred (typically "until" as in "10 more minutes until"). Typically add a space after it.
$pdc_text['until'] = "until ";

// Set this to the text that should display after the time when the event has occurred (typically "since" as in "10 more minutes since"). Typically add a space after it.
$pdc_text['since'] = "since ";

// Set this to the singular and plural form of days (for both non-JavaScript and JavaScript countdowns)
$pdc_text['day'] = "sleep";
$pdc_text['days'] = "sleeps";

// Set this to the singular and plural form of hours (for non-JavaScript countdown)
$pdc_text['hour'] = "hour";
$pdc_text['hours'] = "hours";

// Set this to the singular and plural form of hours (for JavaScript countdown)
$pdc_text['java_hour'] = "h";

// Set this to the singular and plural form of minutes (for non-JavaScript countdown)
$pdc_text['minute'] = "minute";
$pdc_text['minutes'] = "minutes";

// Set this to the singular and plural form of minutes (for JavaScript countdown)
$pdc_text['java_minute'] = "m";

// Set this to the singular and plural form of seconds (for JavaScript countdown only) "s" is recommended for space reasons
$pdc_text['java_second'] = "s";

// You shouldn't have to edit below this line!
// -------------------------------------------

add_action('plugins_loaded', 'peter_displaydatecountdown');

function pdc_noquotes($input) {
    $input = str_replace('"','&quot;',$input);
    $input = str_replace("'",'&#039;',$input);
    return $input;
}

$pdc_text['before'] = pdc_noquotes($pdc_text['before']);
$pdc_text['more'] = pdc_noquotes($pdc_text['more']);
$pdc_text['until'] = pdc_noquotes($pdc_text['until']);
$pdc_text['since'] = pdc_noquotes($pdc_text['since']);

$pdc_message = "";

if ( function_exists(get_option) ) {
    $pdc_siteurl = get_option('siteurl');
}
if ( !$pdc_siteurl) {
    $pdc_message = "The site administrator needs to configure his/her site address in the plugin file!";
}

function countdown_compare($a, $b) {
    if ( $a['date'] < $b['date'] ) {
        return -1;
    }
    
    if ( $a['date'] > $b['date'] ) {
        return 1;
    }
    return 0;
}

function countdown_manage() {
    global $timediff, $datecount_path;
    
    if (isset($_GET['sort'])) {
        require "../" . $datecount_path . "datecountdowndates.php";
        $howmanydates = count($importantdate);

        for ($i = 0; $i < $howmanydates; $i = $i + 1) {
            $month = $importantdate[$i][1] + 0;
            $day = $importantdate[$i][2] + 0;
            $year = $importantdate[$i][3] + 0;
            $hour = $importantdate[$i][5] + 0;
            $minute = $importantdate[$i][6] + 0;
            $importantdate[$i]['date'] = mktime($hour,$minute,0,$month,$day,$year);
        }
        

        usort($importantdate, 'countdown_compare');
        $line[] = "<?php";
        
        $i = 0;
        while ($i < $howmanydates) {
            $itemname = $importantdate[$i][0];
            $itemday = $importantdate[$i][2] + 0;
            $itemmonth = $importantdate[$i][1] + 0;
            $itemyear = $importantdate[$i][3] + 0;
            $itemfinished = $importantdate[$i][4];
            $itemhour = $importantdate[$i][5] + 0;
            $itemminute = $importantdate[$i][6] + 0;
            $itemlink = $importantdate[$i][7];
            $line[] = "$" . "importantdate[$i]=array(\"$itemname\", $itemmonth, $itemday, $itemyear, \"$itemfinished\", $itemhour, $itemminute, \"$itemlink\");";
            ++$i;
        }
    
        $line[] = "?>";
        $mystring = implode("\n", $line);
        $open = fopen("../" . $datecount_path . "datecountdowndates.php", "w");
        fwrite($open, $mystring);
        fclose($open);
    }
    
    if (isset($_GET['deletedate'])) {
        $goback = $_SERVER['HTTP_REFERER'];
        require "../" . $datecount_path . "datecountdowndates.php";
        $line[] = "<?php";
        $howmanydates = count($importantdate);
        $modi = 0;
        
        for ($i = 0; $i < $howmanydates; $i = $i + 1) {
            if ($i == $_GET['deletedate']) {
                continue;
            }
            
            $itemname = $importantdate[$i][0];
            $itemmonth = $importantdate[$i][1] + 0;
            $itemday = $importantdate[$i][2] + 0;
            $itemyear = $importantdate[$i][3] + 0;
            $itemfinished = $importantdate[$i][4];
            $itemhour = $importantdate[$i][5] + 0;
            $itemminute = $importantdate[$i][6] + 0;
            $itemlink = $importantdate[$i][7];
            $line[] = "$" . "importantdate[$modi]=array(\"$itemname\", $itemmonth, $itemday, $itemyear, \"$itemfinished\", $itemhour, $itemminute, \"$itemlink\");";
            $modi = $modi + 1;
        }
        
        $line[] = "?>";
        $mystring = implode("\n", $line);
        $open = fopen("../" . $datecount_path . "datecountdowndates.php", "w");
        fwrite($open, $mystring);
        fclose($open);
        print "<div class=\"wrap\">\n<p>Date deleted!</p>\n<p><a href=\"$goback\">Back</a><p>\n</div>";
    }
    
    else {
        if ($_POST['submit']) {
            $line[] = "<?php";
            $howmanydates = count($_POST['itemname']);
            
            $i = 0;
            while ($i < $howmanydates) {
                $itemname = pdc_noquotes($_POST['itemname'][$i]);
                $itemday = $_POST['itemday'][$i] + 0;
                $itemmonth = $_POST['itemmonth'][$i] + 0;
                $itemyear = $_POST['itemyear'][$i] + 0;
                $itemfinished = pdc_noquotes($_POST['itemfinished'][$i]);
                $itemhour = $_POST['itemhour'][$i] + 0;
                $itemminute = $_POST['itemminute'][$i] + 0;
                $itemlink = $_POST['itemlink'][$i];
                $line[] = "$" . "importantdate[$i]=array(\"$itemname\", $itemmonth, $itemday, $itemyear, \"$itemfinished\", $itemhour, $itemminute, \"$itemlink\");";
                ++$i;
                
                if ($i + 1 == $howmanydates && ($_POST['itemname'][$i] == "" or $_POST['itemday'][$i] == "" or $_POST['itemmonth'][$i] == "" or $_POST['itemyear'][$i] == "") ) {
                    break;
                }
            }
            
            $line[] = "?>";
            $mystring = implode("\n", $line);
            $open = fopen("../" . $datecount_path . "datecountdowndates.php", "w");
            fwrite($open, $mystring);
            fclose($open);
        }
        
        require "../" . $datecount_path . "datecountdowndates.php";
?>
	<div class="wrap">
        <h2>Date Countdown</h2>
        <h3>Current Countdowns:</h3>
        
        <p><strong><a href="<?php print $_SERVER['PHP_SELF']; ?>?page=datecountdownwidget.php&sort">Sort by date, ascending</a></strong></p>
        <p><font color="red">Note: to delete an item, click on the red X, or simply replace the info with a new item!</font></p>

        <form name="currentcountdowns" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?page=datecountdownwidget.php">
<?php
        $howmanydates = count($importantdate);
        $i = 0;
        while ($i < $howmanydates) {
?>
<p><strong><a href="<?php print $_SERVER['PHP_SELF']; ?>?page=datecountdownwidget.php&deletedate=<?php print $i; ?>"><font color="red">X</font></a></strong>&nbsp;&nbsp;Name: <input type="text" name="<?php print "itemname[$i]"; ?>" size="30" maxlength="100" value="<?php print stripslashes(htmlspecialchars($importantdate[$i][0], ENT_NOQUOTES)); ?>" /><br />Month: <input type="text" name="<?php print "itemmonth[$i]"; ?>" size="2" maxlength="2" value="<?php print $importantdate[$i][1]; ?>" /> Day: <input type="text" name="<?php print "itemday[$i]"; ?>" size="2" maxlength="2" value="<?php print $importantdate[$i][2]; ?>" /> Year: <input type="text" name="<?php print "itemyear[$i]"; ?>" size="4" maxlength="4" value="<?php print $importantdate[$i][3]; ?>" /> Hour (24hr): <input type="text" name="<?php print "itemhour[$i]"; ?>" size="2" maxlength="2" value="<?php print $importantdate[$i][5]; ?>" /> Minute: <input type="text" name="<?php print "itemminute[$i]"; ?>" size="2" maxlength="2" value="<?php print $importantdate[$i][6]; ?>" /><br />Text when finished: <input type="text" name="<?php print "itemfinished[$i]"; ?>" size="30" maxlength="100" value="<?php print stripslashes(htmlspecialchars($importantdate[$i][4], ENT_NOQUOTES)); ?>" /><br />
Link to (leave blank for no link): <input type="text" name="<?php print "itemlink[$i]"; ?>" size="30" maxlength="100" value="<?php print $importantdate[$i][7]; ?>" /></p>
<?php
            ++$i;
        }
?>
<h3>Add a new countdown</h3>
<p>Name: <input type="text" name="<?php print "itemname[$i]"; ?>" size="30" maxlength="100" /><br />Month: <input type="text" name="<?php print "itemmonth[$i]"; ?>" size="2" maxlength="2" /> Day: <input type="text" name="<?php print "itemday[$i]"; ?>" size="2" maxlength="2" /> Year: <input type="text" name="<?php print "itemyear[$i]"; ?>" size="4" maxlength="4" /> Hour (24hr): <input type="text" name="<?php print "itemhour[$i]"; ?>" size="2" maxlength="2" /> Minute: <input type="text" name="<?php print "itemminute[$i]"; ?>" size="2" maxlength="2" /><br />Text when finished: <input type="text" name="<?php print "itemfinished[$i]"; ?>" size="30" maxlength="100" /><br />
Link to (leave blank for no link): <input type="text" name="<?php print "itemlink[$i]"; ?>" size="30" maxlength="100" /></p>
<input name="submit" type="submit" value="Update" />
<?php
    }
}

function countdown_callit($dateitem_select=false) {
    global $timediff, $showhours, $showminutes, $numcountdowns, $datecount_path, $pdc_java, $pdc_siteurl, $pdc_message, $pdc_abspath, $pdc_javaend, $pdc_text;

    // Determine the ABSPATH if it is not already defined (thanks to Will Murray who implemented this piece of code on my custom anti-spam plugin)
    if( ! defined( 'ABSPATH' ) && ! $pdc_abspath ) {
    	if (DIRECTORY_SEPARATOR=='/') {
    		$abspath = dirname(__FILE__).'/';
    	}
    	else {
    		$abspath = str_replace('\\', '/', dirname(__FILE__)).'/';
    	}
        
    	$absarray = explode( "/", $abspath );
    	$abspath = "";
    	foreach( $absarray as $value ) {
            $abspath = $abspath . $value . "/";
            if( file_exists( $abspath . "wp-config.php" ) ) {
                if( ! defined( 'ABSPATH' ) ) define( 'ABSPATH', $abspath, true );
            }
        }
    }

    if( ! defined( 'ABSPATH' ) ) {
        define( 'ABSPATH', $pdc_abspath );
    }
    
    require ABSPATH . $datecount_path . "datecountdowndates.php";

    // show only a specific countdown item
    if ($dateitem_select) {
        $i = $dateitem_select - 1;

        // check to see whether that specific countdown item exists
        if ($dateitem_select > count($importantdate)) {
            print "<li>That item number does not exist</li>";
        }

        // execute that specific countdown item
        else {

            // this is the JavaScript version
            if ($pdc_java) {
                print "<script language=\"javascript\" src=\"" . $pdc_siteurl . "/" . $datecount_path . "datecountdownjava.php\"></script>\n";
                if (!empty($pdc_message)) {
                    print "<li>$pdc_message</li>\n";
                }
                print "<li>\n";

                $link = $importantdate[$i][7];
                // show link if there is one
                if ($link <> "") {
                    print "<a href=\"$link\">";
                }

                print "<script type=\"text/javascript\">\n";
                print "countdown_clock({$importantdate[$i][3]}, {$importantdate[$i][1]} - 1, {$importantdate[$i][2]}, {$importantdate[$i][5]}, {$importantdate[$i][6]}, $i, $timediff, $pdc_javaend, '{$importantdate[$i][4]}', '{$importantdate[$i][0]}', '{$pdc_text['day']}', '{$pdc_text['days']}', '{$pdc_text['java_hour']}', '{$pdc_text['java_minute']}', '{$pdc_text['java_second']}', '{$pdc_text['before']}', '{$pdc_text['until']}', '{$pdc_text['since']}');\n";
                print "</script>\n";

                // close link if there is one
                if ($link <> "") {
                    print "</a>";
                }

                print "</li>\n";
            }

            // this is the normal version
            else {
                countdown_execute(stripslashes($importantdate[$i][0]), $importantdate[$i][1], $importantdate[$i][2], $importantdate[$i][3], stripslashes($importantdate[$i][4]), $importantdate[$i][7], $timediff, $importantdate[$i][5], $importantdate[$i][6], $showhours, $showminutes);
            }
        }
    }

    // find out how many countdowns there are in total
    else {
        $howmanydates = count($importantdate);

        // show a certain number of countdowns, if specified
        if ($numcountdowns > 0 && $howmanydates > $numcountdowns) {
            $howmanydates = $numcountdowns;
        }
        
        $i = 0;

        // show the normal view of countdowns
        if (!$pdc_java) {
            while ($i < $howmanydates) {
                countdown_execute(stripslashes($importantdate[$i][0]), $importantdate[$i][1], $importantdate[$i][2], $importantdate[$i][3], stripslashes($importantdate[$i][4]), $importantdate[$i][7], $timediff, $importantdate[$i][5], $importantdate[$i][6], $showhours, $showminutes);
                ++$i;
            }
        }

        // show the JavaScript countdown
        else {
            print "<script language=\"javascript\" src=\"" . $pdc_siteurl . "/" . $datecount_path . "datecountdownjava.php\"></script>\n";
            if (!empty($pdc_message)) {
                print "<li>$pdc_message</li>\n";
            }
            while ($i < $howmanydates) {
                print "<li>\n";

                $link = $importantdate[$i][7];
                // show link if there is one
                if ($link <> "") {
                    print "<a href=\"$link\">";
                }

                print "<script type=\"text/javascript\">\n";
                print "countdown_clock({$importantdate[$i][3]}, {$importantdate[$i][1]} - 1, {$importantdate[$i][2]}, {$importantdate[$i][5]}, {$importantdate[$i][6]}, $i, $timediff, $pdc_javaend, '{$importantdate[$i][4]}','{$importantdate[$i][0]}', '{$pdc_text['day']}', '{$pdc_text['days']}', '{$pdc_text['java_hour']}', '{$pdc_text['java_minute']}', '{$pdc_text['java_second']}', '{$pdc_text['before']}', '{$pdc_text['until']}', '{$pdc_text['since']}');\n";
                print "</script>\n";

                // close link if there is one
                if ($link <> "") {
                    print "</a>";
                }

                print "</li>\n";
                ++$i;
            }
        }
    }
}

function countdown_execute($event,$month,$day,$year,$finished,$link,$timediff,$hour,$minute,$showhours,$showminutes) {
    global $pdc_text, $pdc_showsince;

    // convert to a timestamp
    $dc_timestamp=mktime($hour,$minute,0,$month,$day,$year);

    // subtract desired date from current date and give an answer in terms of days
    $remain = $dc_timestamp - (time() + $timediff * 3600);

    // formulate the actual date to display when users hover over the item
    $dc_datedisplay=date('l, M j, Y g:ia',$dc_timestamp);
    $dc_gmtdiff=date('O')/100 + $timediff; 

    // open the countdown item
    print "<li><a ";

    // display link if desired
    if ($link <> "") {
        print "href=\"$link\" ";
    }

    // display hover of actual date
    print "title=\"$dc_datedisplay (GMT $dc_gmtdiff)\">";

    // if the event has arrived, say so!
    if ($remain < 0 && (!$pdc_showsince)) {
        print "$finished";
    }

    // if set to be so, show the number of days since the event
    elseif ($remain < 0 && $pdc_showsince) {
        // make it a positive number of days
        $remain = floor(($remain * -1) / 86400);
        if ($remain == 1) {
                print $pdc_text['before'];
                print "<strong>$remain</strong> ";
                print $pdc_text['day'] . ' ' . $pdc_text['since'];
                print "$finished";
        }
        
        else {
            print $pdc_text['before'];
            print "<strong>$remain</strong> ";
            print $pdc_text['days'] . ' ' . $pdc_text['since'];
            print "$finished";
        }
    }

    // show the number of minutes remaining (if requested)
    elseif ($remain < 3600 && $showminutes) {
        $remain = ceil($remain / 60);
        if ($remain == 1) {
            print "<strong>$remain</strong> ";
            print $pdc_text['more'] . $pdc_text['minute'] . ' ' . $pdc_text['until'];
            print "$event";
        }
        else {
            print "<strong>$remain</strong> ";
            print $pdc_text['more'] . $pdc_text['minutes'] . ' ' . $pdc_text['until'];
            print "$event";
        }
    }

    // show the number of hours remaining (if requested)
    elseif ($remain < 86400 && $showhours) {
        if (!$showminutes) {
            $remain = ceil($remain / 3600);
        }
        else {
            $remain = round($remain / 3600);
        }
        if ($remain == 1) {
            print "<strong>$remain</strong> ";
            print $pdc_text['more'] . $pdc_text['hour'] . ' ' . $pdc_text['until'];
            print "$event";
        }
        else {
            print "<strong>$remain</strong> ";
            print $pdc_text['more'] . $pdc_text['hours'] . ' ' . $pdc_text['until'];
            print "$event";
        }
    }

    // show the number of days remaining
    else {
        if (!$showhours) {
            $remain = ceil($remain / 86400);
        }
        else {
            $remain = round($remain / 86400);
        }
        if ($remain == 1) {
            print $pdc_text['before'];
            print "<strong>$remain</strong> ";
            print $pdc_text['more'] . $pdc_text['day'] . ' ' . $pdc_text['until'];
            print "$event";
        }
        else {
            print $pdc_text['before'];
            print "<strong>$remain</strong> ";
            print $pdc_text['more'] . $pdc_text['days'] . ' ' . $pdc_text['until'];
            print "$event";
        }
    }

    // close the countdown item
    print "</a></li>\n";
}

function datecountdown_adminmenu(){
global $pdc_userlevel;
	add_management_page('Date Countdown', 'Date Countdown', $pdc_userlevel, 'datecountdownwidget.php', 'countdown_manage');
}

add_action('admin_menu','datecountdown_adminmenu',1);
function widget_peterdatecountdown($args) {
    global $pdc_widget_header;
    
    extract($args);
	echo $before_widget;
    echo $before_title . $pdc_widget_header . $after_title . '<ul>';
	countdown_callit();
	echo '</ul>' . $after_widget;
}
function peter_displaydatecountdown() {
    if ( !function_exists( 'register_sidebar_widget') ) {
        return;
    }
    
    register_sidebar_widget(array('Peter\'s Date Countdown', 'widgets'), 'widget_peterdatecountdown');
}
?>