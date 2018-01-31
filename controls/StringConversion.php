<?php

class StringConversion {

    /**
     * 
     * @param type $strg
     * @return type
     */
    public static function camelConversion($strg) {
        $word = "";
        $symbol = false;

        for ($i = 0; $i < strlen($strg); $i++) {
            $letter = $strg[$i];

            if ($letter == "_") {
                $symbol = true;
            }

            if ($symbol) {
                $letter = $strg[$i];
                $letter = strtoupper($letter);
                $symbol = false;
                $word .= $letter;
            } else {
                $word .= $letter;
            }
        }
        return $word;
    }

    /**
     * 
     * @param type $strg
     * @return type
     */
    public static function normalConversion($strg) {
        $word = "";

        for ($i = 0; $i < strlen($strg); $i++) {
            $letter = $strg[$i];

            if ($letter == "_") {
                $word .= " ";
            } else {
                $word .= $letter;
            }
        }
        $word = strtoupper($word);
        return $word;
    }

}
?>

