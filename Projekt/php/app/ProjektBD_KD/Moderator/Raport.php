<?php 
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if(isset($_POST['raport']))
    {
        include '../conn.php';
        $result = pg_query($_POST['raport']);// or die('Nieprawidłowe zapytanie: ' . pg_last_error());
        header('Content-Description: File Transfer');
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=test.csv');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
            
        while($roww = pg_fetch_array($result, null, PGSQL_ASSOC)) 
        {

            foreach($roww as $column)
            {
                echo $column.";";
            }
            echo "\n";

        }
        include '../endconn.php';

    }
}
else
{
    header('Location: http://pascal.fis.agh.edu.pl/~5mucha1/ProjektBD_KD/Moderator/Moderator.php');
    exit;
}
?>