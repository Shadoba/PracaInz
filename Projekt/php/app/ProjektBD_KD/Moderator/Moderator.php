<!-- Interfejs moderatora -->
<!-- 
    + Korzysta z widoku privateView -> widoczne informacje pozwalające jednoznacznie identyfikować dzieła oraz dane o konserwacji i wartości dzieła
    + Zawiera opcje usuwania i modifikowania rekordów ze wszytskich tabel 
        + Tylko tutaj można zmienić wartość estymowanej wartości dziela (Prywatne_Dane_Obrazu.Estymowana_Wartosc)
    + Korzysta z funkcjonalności plików:
    +++ Header.php
    +++ conn.php
    +++ ModHandler.php
    +++ ModMenu.js
    +++ endconn.php
    +++ footer.php
 -->
<?php include 'Header.php';?>
<?php include 'ModHandler.php';?>
<?php include 'ModMenu.php'; ?>

<main>
    <?php
        $numberOfConserv = false; //determiuje specificzny widok z liczbą dokoanych czynności konserwcyjnych na danym dziele
        $tmpID = -1; //zapobiega duplikowaniu się wyświetlanych danych dzieła
        $tmpConserve = "";  //zapobiega duplikowaniu się wyświetlanych danych konserwacji
        $queryAppend = "ID_Dziela"; //sortuje dziela w tabeli malejąca
        if($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            if(isset($_GET['privateView']))
            {
                if($_GET['privateView'] === 'LiczbaKonserwacji') //wybiera pomiędzy zwykłym widokiem a widokiem z liczbą konserwacji
                {
                    $numberOfConserv = true;
                }
                else
                {
                    $queryAppend = $_GET['privateView'];
                }
            }
        }

        

        /* widok z liczbą konserwacji */
        if($numberOfConserv)
        {
            $query = "SELECT DISTINCT COUNT(kon.id_konserwacji) AS ilosc, pv.id_dziela, pv.tytul, pv.autor, pv.kraj, pv.estymowana_wartosc, pv.status from privateView pv, konserwacja kon, prywatne_dane_obrazu pdo WHERE pv.id_dziela = pdo.id_dziela AND kon.id_prywatnedo = pdo.id_prywatnedo group by pv.id_dziela, pv.tytul, pv.autor, pv.kraj, pv.estymowana_wartosc, pv.status, kon.id_konserwacji order by ilosc DESC;";
            $result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
            echo "<table border=1 cellspacing=0 id='priavteViewTable'>\n";
            echo "<tr><td rowspan='2'>Ilość konserwacji</td><td colspan='6'>Dane dzieła</td>";
            echo "<tr><td>ID dzieła</td><td>Tytuł</td><td>Autor</td><td>Kraj</td><td>Status</td><td>Wartość</td></tr>";

            while ($roww = pg_fetch_array($result, null, PGSQL_ASSOC)) 
            {
                echo "<tr>\n";

                echo "<td> $roww[ilosc] </td>";
                echo "<td> $roww[id_dziela]</td>";
                echo "<td> $roww[tytul] </td>";
                echo "<td> $roww[autor] </td>";
                echo "<td> $roww[kraj] </td>";
                echo "<td> $roww[status] </td>";
                echo "<td> $roww[estymowana_wartosc] </td>";

                echo "</tr>"; 
                
            
            }
            echo "</table>\n";
            pg_free_result($result);
        }
        /* zwykly widok */
        else
        {
            $query = "SELECT d.url_topic, pv.* FROM privateView pv, dzielo d WHERE d.id_dziela=pv.id_dziela ORDER BY ".$queryAppend." DESC";
            $result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
    
            /* Table with private data */           
            echo "<table class='Tabela' border=1 cellspacing=0  id='priavteViewTable'>\n";
            echo "<tr><td rowspan='2'>ID</td><td colspan='6'>Dane dzieła</td><td colspan='3'>Dane konserwacji</td><td rowspan='2'>Opcje</td></tr>";
            echo "<tr><td>miniaturka</td><td>Tytuł</td><td>Autor</td><td>Kraj</td><td>Status</td><td>Wartość</td><td>Data</td><td>Czynność</td><td>Konserwator</td></tr>";

            while ($roww = pg_fetch_array($result, null, PGSQL_ASSOC)) 
            {
                if($tmpID === $roww[id_dziela])
                {
                    if($tmpConserve === "$roww[data], $roww[typ]")
                    {
                        echo "<tr>\n";

                        for($i = 0; $i < 9; $i++)
                        echo "<td></td>";
                        echo "<td> $roww[konserwator] </td>";
                        echo "<td></td>";
                    }
                    else
                    {
                        echo "<tr>";

                        for($i = 0; $i < 7; $i++)
                        {
                            echo "<td></td>";
                        }
                        echo "<td> $roww[data] </td>";
                        echo "<td> $roww[typ] </td>";
                        echo "<td> $roww[konserwator] </td>";
                        echo "<td></td>";
                    }

                    echo "</tr>";

                    $tmpConserve = "$roww[data], $roww[typ]";
                }
                else
                {
                    $tmpID = $roww[id_dziela];
                    echo "<tr>";
                    
                    echo "<td> $roww[id_dziela]</td>";
                    echo "<td> <a target='_blank' href='$roww[url_topic]'>
                    <img src='$roww[url_topic]' alt='$roww[id_dziela]'>
                    </a></td>";
                    echo "<td> $roww[tytul] </td>";
                    echo "<td> $roww[autor] </td>";
                    echo "<td> $roww[kraj] </td>";
                    echo "<td> $roww[status] </td>";
                    echo "<td> $roww[estymowana_wartosc] </td>";
                    echo "<td> $roww[data] </td>";
                    echo "<td> $roww[typ] </td>";
                    echo "<td> $roww[konserwator] </td>";
                    echo "<td><form method='POST' action='Moderator.php'>
                            <input type='text' name='action' value='delete' style='display:none'> 
                            <input type='text' name='table' value='dzielo' style='display:none'> 
                            <input type='text' name='ID' value='id_dziela' style='display:none'>
                            <input type='number' name='value' value='$roww[id_dziela]' style='display:none'>                               
                            <input type='submit' value='Usuń'>
                            </form>
                            <button onclick=\"getElementsByName('updateDzielo$roww[id_dziela]')[0].style.display='block'\">Zmień</button>
                            <div id='updateAutor' name='updateDzielo$roww[id_dziela]' class='modal'>
                            <form class='modal-content animate' method='POST' action='Moderator.php'>
                                <div id='container-1' class='container'>
                                <input type='text' name='action' value='updateDzielo' style='display:none'>
                                <input type='number' name='IDvalue' value='$roww[id_dziela]' style='display:none'>
                                <input type='text' name='col1' value='url_topic' style='display:none'>
                                <input type='text' name='url_topic' value='$roww[url_topic]'>
                                <input type='text' name='tytul' value='$roww[tytul]'>
                                <label for='Autor'><b>Autor</b></label>
                                <select name='Autor'>".
                                    getAuthor()."
                                </select>
                                <label for='Gatunek'><b>Gatunek</b></label>
                                <select name='Gatunek'>".
                                    getOptions('Gatunek')."
                                </select>
                                <label for='Rodzaj'><b>Rodzaj</b></label>
                                <select name='Rodzaj'>".
                                    getOptions('Rodzaj')."
                                </select>
                                <label for='Material'><b>Material</b></label>
                                <select name='Material'>".
                                    getOptions('Material')."
                                </select>
                                <label for='Status'><b>Status</b></label>
                                <select name='Status'>".
                                    getOptions('Status')."
                                </select>
                                <label for='Data'><b>Data powstania</b></label>
                                <input type='date' name='Data' value='$roww[data]'>
                                <label for='estymowana_wartosc'><b>Estymowana wartość</b></label>
                                <input type='text' name='estymowana_wartosc' value='$roww[estymowana_wartosc]'>
                                <input type='submit' value='Zmień'>
                                <aside>Zostaw puste wartości w rozwiajnych listach aby nie zmienić wartości w odpowiadających kolumnach</aside>
                            </div>
                            </form></div></td>";

                    echo "</tr>"; 
                }
            }
            echo "</table>\n";
            
            echo "<form method='POST' action='Raport.php'>
            <input type='text' name='raport' value='$query' style='display:none'> 
            <input type='submit' value='Raport'>
            </form>";
            pg_free_result($result);
        }
    ?>
</main>



<?php include '../Footer.php';?>
