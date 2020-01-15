<?php
/**
 * @brief dokłada nowe roekordy do bazy 
 */
$errorMsg = "";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if(isset($_POST['action']))
    {
        switch($_POST['action'])
        {
            case 'addNewArt':
                $query = 'SELECT addNewArt(addNewPiece( \''.$_POST['url_topic'].'\', '.$_POST['Autor'].'), \''.$_POST['Tytul'].'\'::TEXT, \''.$_POST['Data'].'\'::TEXT, '.$_POST['Gatunek'].', '.$_POST['Rodzaj'].', '.$_POST['Status'].', '.$_POST['Material'].')';
                $result = pg_query($query);
                if(!$result)
                {
                    $errorMsg = 'Nieprawidłowe zapytanie: ' . pg_last_error();
                }
                pg_free_result($result);
                break;
            case 'addAuthor':
                $post = $_POST;
                $query = 'INSERT INTO Autor (Nazwa, Kraj) VALUES (\''.$_POST['Nazwa'].'\', \''.$_POST['Kraj'].'\')';
                $result = pg_query($query);
                if(!$result)
                {
                    $errorMsg = 'Nieprawidłowe zapytanie: ' . pg_last_error();
                }
                pg_free_result($result);
                break;
            case 'addConserv':
                $post = $_POST;
                $query = 'INSERT INTO Konserwator (Nazwa) VALUES (\''.$_POST['Nazwa'].'\')';
                $result = pg_query($query);
                if(!$result)
                {
                    $errorMsg = 'Nieprawidłowe zapytanie: ' . pg_last_error();
                }
                pg_free_result($result);
                break;
            case 'addConservEvent':
                $post = $_POST;
                $query = 'INSERT INTO Konserwacja (id_prywatnedo, data, typ_konserwacji) VALUES ('.$_POST['id_prywatnedo'].', \''.$_POST['Data'].'\', \''.$_POST['Typ_Konserwacji'].'\')';
                $result = pg_query($query);
                if(!$result)
                {
                    $errorMsg = 'Nieprawidłowe zapytanie: ' . pg_last_error();
                }
                pg_free_result($result);
                break;
            case 'addMaterial':
                $post = $_POST;
                $query = 'INSERT INTO Material (Nazwa) VALUES (\''.$_POST['Nazwa'].'\')';
                $result = pg_query($query);
                if(!$result)
                {
                    $errorMsg = 'Nieprawidłowe zapytanie: ' . pg_last_error();
                }
                pg_free_result($result);
                break;
            case 'addStatus':
                $post = $_POST;
                $query = 'INSERT INTO Status (status_dziela) VALUES (\''.$_POST['Nazwa'].'\')';
                $result = pg_query($query);
                if(!$result)
                {
                    $errorMsg = 'Nieprawidłowe zapytanie: ' . pg_last_error();
                }pg_free_result($result);
                break;
            case 'addGenre':
                $post = $_POST;
                $query = 'INSERT INTO Gatunek (Nazwa) VALUES (\''.$_POST['Nazwa'].'\')';
                $result = pg_query($query);
                if(!$result)
                {
                    $errorMsg = 'Nieprawidłowe zapytanie: ' . pg_last_error();
                }
                pg_free_result($result);
                break;
            case 'addType':
                $post = $_POST;
                $query = 'INSERT INTO Rodzaj (Nazwa) VALUES (\''.$_POST['Nazwa'].'\')';
                $result = pg_query($query);
                if(!$result)
                {
                    $errorMsg = 'Nieprawidłowe zapytanie: ' . pg_last_error();
                }
                pg_free_result($result);
                break;
            case 'addConservEventRel':
                $post = $_POST;
                $query = 'INSERT INTO Konserwator_konserwacja (id_konserwacji, id_konserwatora) VALUES ('.$_POST['id_konserwacji'].', '.$_POST['id_konserwatora'].')';
                $result = pg_query($query);
                if(!$result)
                {
                    $errorMsg = 'Nieprawidłowe zapytanie: ' . pg_last_error();
                }
                pg_free_result($result);
                break;   
            case 'delete' :
                $query = 'DELETE FROM '.$_POST['table'].' WHERE '.$_POST['ID'].'='.$_POST['value'];
                $result = pg_query($query);
                if(!$result)
                {
                    $errorMsg = 'Nieprawidłowe zapytanie: ' . pg_last_error();
                }
                pg_free_result($result);
                break;
            case 'updateSimple':
                $post = $_POST;
                $query = 'UPDATE '.$_POST['table'].' SET '.$_POST['column'].'=\''.$_POST['value'].'\' WHERE '.$_POST['ID'].'='.$_POST['IDvalue'];
                $result = pg_query($query);
                if(!$result)
                {
                    $errorMsg = 'Nieprawidłowe zapytanie: ' . pg_last_error();
                }
                pg_free_result($result);
                break;
            case 'updateAutor':
                $post = $_POST;
                $query = 'UPDATE '.$post['table'].' SET '.$post['col1'].' =\''.$post['value1'].'\' WHERE '.$post['ID'].'='.$post['IDvalue'].';';
                $query .= ' UPDATE '.$post['table'].' SET '.$post['col2'].' =\''.$post['value2'].'\' WHERE '.$post['ID'].'='.$post['IDvalue'].';';
                $result = pg_query($query);
                if(!$result)
                {
                    $errorMsg = '<br>Nieprawidłowe zapytanie: ' . pg_last_error();
                }
                
                pg_free_result($result);
                break;
            case 'updateDzielo':
                $post = $_POST;
                $query = "";
                if(!empty($post['url_topic']))
                    $query .= 'UPDATE Dzielo SET Url_toPic =\''.$post['url_topic'].'\' WHERE id_dziela='.$post['IDvalue'].';';
                if($post['Autor'] === 'null')
                    $query .= ' UPDATE Dzielo_Autor SET id_autora=\''.$post['Autor'].'\' WHERE id_dziela='.$post['IDvalue'].';';
                if(!empty($post['estymowana_wartosc']))
                    $query .= ' UPDATE Prywatne_Dane_Obrazu SET  estymowana_wartosc=\''.$post['estymowana_wartosc'].'\' WHERE id_dziela='.$post['IDvalue'].';';
                if($post['Gatunek'] === 'null')
                    $query .= ' UPDATE Dane_Publiczne_Dziela SET ID_Gatunku =\''.$post['Gatunek'].'\' WHERE id_dziela='.$post['IDvalue'].';';
                if(!empty($post['tytul']))
                    $query .= ' UPDATE Dane_Publiczne_Dziela SET Tytul =\''.$post['tytul'].'\' WHERE id_dziela='.$post['IDvalue'].';';
                if($post['Rodzaj'] === 'null')
                    $query .= ' UPDATE Dane_Publiczne_Dziela SET ID_Rodzaju =\''.$post['Rodzaj'].'\' WHERE id_dziela='.$post['IDvalue'].';';
                if($post['Status'] === 'null')
                    $query .= ' UPDATE Dane_Publiczne_Dziela SET ID_Statusu =\''.$post['Status'].'\' WHERE id_dziela='.$post['IDvalue'].';';
                if($post['Data'] === 'mm/dd/rrrr')
                    $query .= ' UPDATE Dane_Publiczne_Dziela SET Data_Powstania =\''.$post['Data'].'\' WHERE id_dziela='.$post['IDvalue'].';';
                if($post['Material'] === 'null')
                    $query .= ' UPDATE Dane_Publiczne_Dziela SET ID_Materialu =\''.$post['Material'].'\' WHERE id_dziela='.$post['IDvalue'].';';
                
                    $result = pg_query($query);
                if(!$result)
                {
                    $errorMsg = '<br>Nieprawidłowe zapytanie: ' . pg_last_error();
                }
                
                pg_free_result($result);
                break;
        }
    }
}



echo $errorMsg;


?>