<!DOCTYPE html>

<html>
    <head>
        <title>Interface DTOGenerator</title>
        <style>
            .dbList{
                display:inline-block;
            }
        </style>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
        $db = filter_input(INPUT_POST, "dbName");
        $tableName = filter_input(INPUT_POST, "tableName");

        try {
            //Connexion a la BD
            $cnx = new PDO("mysql:host=localhost;port=8889;dbname=5Minutes", "root", "root");
            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $cnx->exec("SET NAMES 'UTF8'");
        } catch (Exception $ex) {
            $cnx = $ex->getMessage();
        }
        $dbList = getDB($cnx);
        ?>
        <div class="dbList">
            <h3>Databases</h3>
            <form method="post" id="dbSel">
                <select onchange="dbSel.submit();" name="dbName" size='30'>
                    <?php
                    foreach ($dbList as $value) {
                        echo "<option value='";
                        echo $value;
                        echo "' ";
                        if ($db AND $db === $value) {
                            echo 'selected';
                        }
                        echo ">";
                        echo $value;
                        echo "</option><br>";
                    }
                    ?>
                </select>
                <br>
            </form></div>

        <?php
        if ($db) {
            $tableList = getTables($cnx, $db);
            echo '<div class="dbList">';
            echo '<h3>Tables</h3>';
            echo '<form id="tableSel" method="post">';
            echo '<select name="tableName" size="30">';

            foreach ($tableList as $value) {
                echo "<option value='";
                echo $value;
                echo "' ";
                if ($tableName AND $tableName === $value) {
                    echo 'selected';
                }
                echo ">";
                echo $value;
                echo "</option><br>";
            }

            echo "</select>";
            echo "<br>";
            echo '</form>';
            echo '</div>';
        }
        ?>
        <form method="get" action="../controls/DTOGenerator.php">
            <input type='submit' value='Générer le DTO'/>
        </form>
    </body>
</html>

<?php

/**
 * 
 * @param PDO $cnx
 * @return type
 */
function getDB(PDO $cnx) {
    $dbList = array();
    $req = $cnx->query("SELECT schema_name FROM information_schema.schemata WHERE schema_name NOT IN('mysql', 'test', 'sys', 'information_schema', 'performance_schema') ORDER BY schema_name");
    $req->setFetchMode(PDO::FETCH_NUM);
    while ($row = $req->fetch()) {
        $dbList[] = $row[0];
    }
    return $dbList;
}

/**
 * 
 * @param PDO $cnx
 * @param type $db
 * @return type
 */
function getTables(PDO $cnx, $db) {
    $tableList = array();
    $req = $cnx->query("SELECT TABLE_NAME FROM information_schema.tables WHERE TABLE_SCHEMA='$db'");
    $req->setFetchMode(PDO::FETCH_NUM);
    while ($row = $req->fetch()) {
        $tableList[] = $row[0];
    }
    return $tableList;
}
?>