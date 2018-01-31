<?php

/**
 * 
 * @param type $table
 * @param type $column
 * @return string
 */
//function generateDTO($table, $column) {
//    require_once 'Metabase.php';
//    require_once 'StringConversion.php';
//    
//    $file = fopen('dto.php', 'w');
//
//    $content1 = "<?php\n\nclass " . ucfirst($table) . " {\n\n";
//    $attributes = "private $" . StringConversion::camelConversion($column) . ";\n";
//    $content2 = "public function __construct($" . StringConversion::camelConversion($column) . " = '',";
//    $content3 = " {\n $" . "this->" . StringConversion::camelConversion($column) . " = $" . StringConversion::camelConversion($column) . ";\n }\n";
//
//    $getter .= "public function get" . ucfirst(StringConversion::camelConversion($column)) . "() {\n return $" . "this->" . StringConversion::camelConversion($column) . ";\n}\n";
//    $setter .= "public function set" . ucfirst(StringConversion::camelConversion($column)) . "($" . StringConversion::camelConversion($column) . ") {\n $" . "this->" . StringConversion::camelConversion($column) . ";\n}\n";
//
//    $content2 = substr($content2, 0, -1);
//    $content2 .= ")\n";
//
//    $content = $content1 . $attributes . $content2 . $content3 . $getter . $setter . "}";
//
//    fwrite($file, $content);
//    fclose($file);
//
//    return $content;
//}
//
//$table = Rubrique;
//$column = idRubrique;
//generateDTO($table, $column);

/**
 * 
 * @param type $cnx
 * @param type $db
 * @param type $table
 */
function generateDTO($cnx, $db, $table) {

    $getter = "";
    $setter = "";
    $attributes = "";
    $content1 = "";
    $content2 = "";
    $content3 = "";

    require_once '../lib/Metabase.php';
    require_once 'StringConversion.php';
    //Creation du nom du fichier avec 1ere lettre en majuscule
    $filename = ucfirst($table) . "DTO.php";

    try {
        //Création du fichier en mode ecriture
        $file = fopen($filename, 'w');
        //Recuperation des noms des colonnes de la table selectionnee
        $column = Metabase::getColumnsNamesFromTable($cnx, $db, $table);

        //Creation balise php ouvrante ainsi que la classe
        $content1 .= "<?php\n\nclass " . ucfirst($table) . " {\n\n";
        //
        $content2 .= "public function __construct(";
        $content3 .= "{\n";

        //On parcours le tableau des colonnes
        for ($i = 0; $i < count($column); $i++) {
            $attributes .= "private $" . StringConversion::camelConversion($column[$i]) . ";\n";
            //echo "<br>$attributes<br>";
            $content2 .= "$" . StringConversion::camelConversion($column[$i]) . " = '',";
            $content3 .= "$" . "this->" . StringConversion::camelConversion($column[$i]) . " = $" . StringConversion::camelConversion($column[$i]) . ";\n";

            $getter .= "public function get" . ucfirst(StringConversion::camelConversion($column[$i])) . "() {\n return $" . "this->" . StringConversion::camelConversion($column[$i]) . ";\n}\n";
            $setter .= "public function set" . ucfirst(StringConversion::camelConversion($column[$i])) . "($" . StringConversion::camelConversion($column[$i]) . ") {\n $" . "this->" . StringConversion::camelConversion($column[$i]) . ";\n}\n";
        }

        //Pour enlever la virgule lors du dernier passage
        $content2 = substr($content2, 0, -1);
        $content2 .= ")";
        $content3 .= "}\n";

        //concatenation pour avoir le DTO en entier
        $content = $content1 . $attributes . $content2 . $content3 . $getter . $setter . "}";
        //echo "<br>$content<br>";
    } catch (Exception $ex) {
        $content = $ex->getMessage();
    }
    fwrite($file, $content);
    fclose($file);

    //return $content;
}

$cnx = new PDO("mysql:host=localhost;port:8889;dbname=5Minutes", "root", "root");
$cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$cnx->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);
$cnx->exec("SET NAMES 'UTF8'");
$db = "cours";
$table = "communes";


generateDTO($cnx, $db, $table);
?>