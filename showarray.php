<?php

/**
 * Utility function to build HTML table from an array.
 * 
 * Reference: http://www.terrawebdesign.com/multidimensional.php
 */

    function htmlShowArray($array) {
        html_show_array($array);
    }

    function html_show_array($array) {
        echo "<table cellspacing='0' border='1'>\n";
        show_array($array, 1, 0);
        echo "</table>\n";
    }


    function show_array($array, $level, $sub) {
        if (is_array($array) == 1) {          // check if input is an array
            foreach($array as $key_val => $value) {
                $offset = "";
                if (is_array($value) == 1){   // array is multidimensional
                    echo "<tr>";
                    $offset = do_offset($level);
                    echo $offset . "<td>" . $key_val . "</td>";
                    show_array($value, $level+1, 1);
                } else { // (sub)array is not multidim
                    if ($sub != 1){ // first entry for subarray
                        echo "<tr nosub>";
                        $offset = do_offset($level);
                    }
                    $sub = 0;
                    echo $offset ."<td width='180px'>" . $value . "</td>";
                    echo "</tr>\n";
                }
            } //foreach $array
        } else { 
            // argument $array is not an array
            return;
        }
    }

    function do_offset($level){
        $offset = ""; // offset for subarry 
        for ($i=1; $i<$level;$i++) {
            $offset = $offset . "<td></td>";
        }
        return $offset;
    }
?>
 