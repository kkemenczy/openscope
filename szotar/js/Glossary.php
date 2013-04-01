<?php

require_once ('../config.inc.php');
require_once 'error-handling.php';
require_once 'TabDelimitedGlossaryPersister.php';

putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain("tm", $localedir);
textdomain("tm");

class Glossary {
	var $persister;
	var $definitions;

	function Glossary() {
		$this->persister = new TabDelimitedGlossaryPersister($GLOBALS['file_glossary'], $GLOBALS['file_history']);
		$this->definitions = $this->persister->load();
	}

	function search($keyword) {
        global $base_url_wiki;
		if (is_error($this->definitions)) return $this->definitions;

		$results = '<table class=clickable><th width="25%">' . _("Term") .'</th><th width="50%">' . _("Translation") . '</th><th>' . _("Meta info") . '</th>';

		$keyword = trim($keyword);
		if (empty($keyword)) {
			return '';
		}

		$class = "light";
		$class2 = "";
		$resultCnt = 0;

		$searchKwd = preg_quote($keyword, "#");
		foreach ($this->definitions as $term => $definition) {
			$contains=False;
			$splitted_words = explode(" ",$term);
        		foreach($splitted_words as $word){
                		if (strpos(strtolower($word),strtolower($searchKwd)) === 0) {
					$contains=True;
                		}
        		}
			//if (preg_match("#^" . $searchKwd . "#i", $term)) {
			if($contains) {
				$resultCnt++;
				$arr = explode("\t", $definition, 2);
				$term = $this->_encode($term);
				$link = array();
				
				if(!$arr[1]) $arr[1] = "";
				if (preg_match("/!/i", $arr[1])) {
				    $class2 = $class . " term_locked";
				    } 
				elseif (preg_match("/\?/i", $arr[1])) {
				    $class2 = $class . " term_debate";
				} else {
				    $class2 = $class . " term_old";
				    ;
				    };
				        
				if (preg_match('/\[\[(.+)\]\]/', $arr[1], $link))
				    $link = "<a target=\"_top\" href=\"$base_url_wiki/$link[1]\">$link[1]</a>";
				else
				    $link ="";
				$definition = $this->_encode($definition);
				$results .= "<tr class=\"$class2\"><td onClick=\"edit('" . $term . "')\">$term</td>" .
				"<td onClick=\"edit('" . $term . "')\">$arr[0]</td><td>$link</td></tr>";
				$class = ($class == 'light') ? 'dark' : 'light';
			}
		}

		if ($resultCnt < 1) {
			$results .= '<tr><td colspan=2 align=center>'. _("Zero results.") .'</td></tr>';
		}

		$results .= '</table>';

		return $results;
	}

	function search_txt($keyword) {
        global $base_url_wiki;
		if (is_error($this->definitions)) return $this->definitions;

		$results = '';

		$keyword = trim($keyword);
		if (empty($keyword)) {
			return '';
		}

		$resultCnt = 0;

		$searchKwd = preg_quote($keyword, "#");
		foreach ($this->definitions as $term => $definition) {
			if (preg_match("#^" . $searchKwd . "#i", $term)) {
				$resultCnt++;
				$term = $this->_encode($term);
				$link = array();
				if (preg_match('/\[\[(.+)\]\]/', $definition, $link))
				    $link = "$base_url_wiki/$link[1]";
				else
				    $link ="";
				$definition = $this->_encode($definition);
				$results .= "$term = $definition $link\n";
			}
		}

		if ($resultCnt < 1) {
			$results .= _("nothing found");
		}

		$results .= '';

		return $results;
	}

	function get($keyword) {
		if (is_error($this->definitions)) return $this->definitions;

		$result = array();

		$keyword = trim($keyword);
		$searchKwd = preg_quote($keyword, "#");
		foreach ($this->definitions as $term => $definition) {
			if (preg_match("#^" . $searchKwd . "$#i", $term)) {
				return $this->_getWithHistory($term, $definition);
			}
		}

		return $result;
	}

	function _getWithHistory($term, $definition) {
		$fcontents = file($GLOBALS['file_history']);
		$len = strlen($term);
		$result['term'] = $term;
		$result['definition'] = $definition;

		$history = "<table class=clickable><tr><th>"._("Term")."</th><th>"._("Context")."</th><th>"._("Revision date")."</th><th>"._("Translation")."</th><th>"._("User / IP")."</th></tr>";
		$class = "light";
		$fcontents = array_reverse($fcontents);
		foreach ($fcontents as $line) {
			if (substr($line, 0, $len + 1) == "$term\t") {
				$line .= "\t\t\t\t\t"; // just to be sure we don't get an error on next line
				list ($term, $oldDefinition, $context, $date, $ip) = explode("\t", $line);

				$term = $this->_encode($term);
				$oldDefinition = $this->_encode($oldDefinition);

				$history .= "<tr class=$class>" .
						"<td>$term</td><td>$context</td><td class=date onClick=\"revert('" . $oldDefinition . "')\">$date</td>" .
						"<td  onClick=\"revert('" . $oldDefinition . "')\">$oldDefinition</td><td>$ip</td></tr>";
				$class = ($class == 'light') ? 'dark' : 'light';
			}
		}

		$result['history'] = $history . "</table>";
		return $result;
	 }

	function save($term, $definition) {
		
		$tmp = 'save(' . $term . ',' . $definition . ')';
		error_log($tmp);
//		fwrite(STDERR, $tmp);
		$term = strtolower($this->_filterSpecialChars(trim($term)));
		$definition = $this->_filterSpecialChars($definition);
//		$meta = $this->_filterSpecialChars($meta);

		if (isset($this->definitions[$term]) && $this->definitions[$term] == $definition) {
			return;
		}

		$this->definitions[$term] = $definition; //# + "###" + $meta;

		$result = $this->persister->saveHistory($term, $definition);
		if (is_error($result)) return $result;

		return $this->persister->save($this->definitions);
	}

	function getStats() {
		
		 $locked = 0;
		 $debate = 0;
		 $count = 0;
		 $others = 0;
		foreach ($this->definitions as $key => $value) {
		    if (strstr($value,'!')) { $locked += 1; }
		    elseif (strstr($value,'?')) { $debate += 1; }
		    else {$others += 1;};
		    $count += 1;
		    }
		
		$rez = "<span class='term_locked'>".
                vsprintf(ngettext("%.1f%% fixed", "%.1f%% fixed", ($locked*100.0/$count)),($locked*100.0/$count)).
                "</span>, <span class='term_debate'>" . 
                vsprintf(ngettext("%.1f%% unfixed", "%.1f%% unfixed", ($debate*100.0/$count)),($debate*100.0/$count)) .
                "</span>, <span class='term_old'>" .
                vsprintf(ngettext("%.1f%% unsorted", "%.1f%% unsorted", ($others*100.0/$count)),($debate*100.0/$count)) .
                "</span>";
        return $rez;
	}

	function getCount() {
		if (is_error($this->definitions)) return $this->definitions;

		$ret = vsprintf(
                ngettext( 
                    "( %d term )",
                    "( %d terms )",
                    count($this->definitions)
                ), 
                count($this->definitions)
                ); 

        $ret .= $this->getStats();
        
        return $ret;
	}


	function _filterSpecialChars($str) {
		// we already concatenating the meta field with \t prefix
		return strtr($str, "\n", " ");	
#		return strtr($str, "\t\n", "  ");
	}

	function _encode($str) {
		return htmlentities($str, ENT_QUOTES, 'UTF-8');
	}
}

?>
