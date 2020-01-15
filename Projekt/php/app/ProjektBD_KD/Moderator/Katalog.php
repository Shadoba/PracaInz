<!-- Katalog moderatora -->
<!-- 
    + Korzysta z widoku allView -> widoczne wszelkie możliwe informacje dla danego dzieła
    + Zawiera możliwości katalogu użytkownika oraz opcje usuwania i modifikowania rekordów z
      tabel: Dzielo, Dzielo_Autor, Publiczne_Dane_Dziela, Prywatne_Dane_dziela
    + Tylko tutaj można zmienić wartość estymowanej wartości dziela (Prywatne_Dane_Obrazu.Estymowana_Wartosc)
    + Korzysta z funkcjonalności plików:
    +++ Moderator/Header.php
    +++ conn.php
    +++ ModMenu.js
    +++ swap.js
    +++ ModHandler.php
    +++ endconn.php
    +++ footer.php
 -->

<?php include 'Header.php';?>
<?php include 'ModHandler.php';?>
<main>
    <nav>
        <!-- swap.js odpowiada z zmiane opcji Pokaż/sortuj -->
        <script src="../swap.js"></script>
        <!-- formularz wysyłający kryteria ograniczania widoku lub jego sortowania -->
        <form class="PublicRecordsNavigator" action="Katalog.php" method="POST">
            <div class="container">
                <label for="ShowOrder"><b>Pokaż/Sortuj</b></label>
                <input type="radio" name="ShowOrder" value="Pokaż" onclick="swapToShow()" CHECKED>
                <input type="radio" name="ShowOrder" value="Sortuj" onclick="swapToOrder()">
            <div id="container-1" class="container">
                <label for="Autor"><b>Autor</b></label>
                <select name="Autor">
                    <?php echo getOptions('Autor')?>
                </select>
                <label for="Kraj"><b>Kraj</b></label>
                <select name="Kraj">
                    <?php echo getOptions('Kraj')?>
                </select>
                <label for="Gatunek"><b>Gatunek</b></label>
                <select name="Gatunek">
                    <?php echo getOptions('Gatunek')?>
                </select>
                <label for="Rodzaj"><b>Rodzaj</b></label>
                <select name="Rodzaj">
                    <?php echo getOptions('Rodzaj')?>
                </select>
                <label for="Material"><b>Material</b></label>
                <select name="Material">
                    <?php echo getOptions('Material')?>
                </select>
                <label for="Status"><b>Status</b></label>
                <select name="Status">
                    <?php echo getOptions('Status')?>
                </select>
                <button type="submit">Aktualizuj</button>
            </div>
            <div id="container-2" class="container"></div>
        </form>
    </nav>

    <div>
        <?php
        /**
         * @brief Generuje widok tabeli allView z uwzględnieniem ograniczeń lub kryterium sortowania
         */
            $query = "SELECT DISTINCT av.* FROM allView av, rodzaj r, material m, dzielo_autor da, autor a, gatunek g, status s";
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                if($_POST['ShowOrder'] === 'Pokaż')//Ogranicza widok
                {
                    $anyFilterActive = false;
                    foreach($_POST as $key => $value)
                    {
                        if($value != 'null' && !empty($value) && $key != 'ShowOrder')
                        {
                            if($anyFilterActive == false) //Klazula WHERE jest dokładana dokłądnie raz
                                $query .= " WHERE";
                                
                            $anyFilterActive = true; //Sprawdza czy jakiś filtr został użyty
                            if($key == 'Autor')
                                $query .= " av.id_dziela = (SELECT DA.id_dziela FROM Dzielo_Autor DA
                                WHERE DA.ID_Autora =".$value.")";
                            elseif($key == 'Kraj')
                                $query .= ' da.id_dziela = av.id_dziela and DA.ID_Autora = A.ID_Autora AND A.Kraj = \''.$value.'\'';
                            elseif($key == 'Gatunek')
                                $query .= " g.nazwa = av.gatunek and g.id_gatunku = ".$value;  
                            elseif($key == 'Rodzaj')
                                $query .= " r.nazwa = av.rodzaj and r.id_Rodzaju = ".$value;  
                            elseif($key == 'Material')
                                $query .= " m.nazwa = av.material and m.id_materialu = ".$value;  
                            elseif($key == 'Status')
                                $query .= " s.status_dziela = av.status and s.id_statusu = ".$value;
                            else
                            {
                                alert("coś poszło nie tak przy wysyłaniu filtru show");
                            }
                            $query .= " AND";
                        }
                    }
                    if($anyFilterActive == true)
                        $query = substr($query, 0, -4);
                }
                if($_POST['ShowOrder'] === 'Sortuj') //sortuje
                {
                    $anyFilterActive = false;
                    foreach($_POST as $key => $value)
                    {
                        if($value != 'null' && !empty($value) && $key != 'ShowOrder')
                        {
                            if($anyFilterActive == false)
                                $query .= " ORDER BY ";
                                
                            $anyFilterActive = true; ///Sprawdza czy jakiś filtr został użyty
                            if($key == 'Autor')
                                $query .= "Autor ".$value;
                            elseif($key == 'Kraj')
                                $query .= "Kraj ".$value."";
                            elseif($key == 'Gatunek')
                                $query .= "Gatunek ".$value;  
                            elseif($key == 'Rodzaj')
                                $query .= "Rodzaj ".$value;  
                            elseif($key == 'Material')
                                $query .= "Material = ".$value;  
                            elseif($key == 'Status')
                                $query .= "Status ".$value;  
                            else
                            {
                                alert("coś poszło nie tak przy wysyłaniu filtru show");
                            }
                            $query .= ", ";
                        }
                    }
                    if($anyFilterActive == true) //usuwa ostatnie słowo AND z zapytania
                        $query = substr($query, 0, -2);
                }
            }
            $result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());

            echo "<table class='Tabela' id='allViewTable' border=1 cellspacing=0>\n";
            echo "<tr><th>ID</th><th>Miniaturka</th><th>Tytuł</th><th>Autor</th><th>Kraj</th><th>Gatunek</th><th>Rodzaj</th><th>Material</th><th>Data wykonania</th><th>Status</th><th>data konserwacji</th><th>Rodzaj konserwacji</th><th>Konserwator</th><th>opcje</th></tr>";
            
            $tmpID = -1; //tymczasowa zmienna zapewniająca to, że w tabeli wyświtlonej na stronie będzie duplikatów danych dzieła
            $tmpConserve = ""; //tymczasowa zmienna zapeniająca to, że tabeli nie będzie duplikatów danych konserwacji

            while ($roww = pg_fetch_array($result, null, PGSQL_ASSOC)) 
            {
                echo "<tr>\n";
                if($tmpID === $roww[id_dziela])
                {
                    if($tmpConserve === "$roww[data], $roww[typ]")
                    {
                        for($i = 0; $i < 12; $i++)
                        echo "<td></td>";
                        echo "<td> $roww[konserwator] </td>";
                        echo "<td></td>";
                    }
                    else
                    {
                        for($i = 0; $i < 10; $i++)
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
                    echo "<td> $roww[id_dziela] </td>";
                    echo "<td><a target='_blank' href='$roww[url_topic]'>
                    <img src='$roww[url_topic]' alt='$roww[id_dziela]'>
                    </a></td>";
                    echo "<td> $roww[tytul] </td>";
                    echo "<td> $roww[autor] </td>";
                    echo "<td> $roww[kraj] </td>";
                    echo "<td> $roww[gatunek] </td>";
                    echo "<td> $roww[rodzaj] </td>";
                    echo "<td> $roww[material] </td>";
                    echo "<td> $roww[data_powstania] </td>";
                    echo "<td> $roww[status] </td>";
                    if(empty($roww[data]))
                        echo "<td> Konserwacja nie<br>miała miejsca </td>";
                    else
                        echo "<td> $roww[data] </td>";
                    if(empty($roww[typ]))
                        echo "<td> --- </td>";
                    else
                        echo "<td> $roww[typ] </td>";
                    if(empty($roww[konserwator]))
                        echo "<td> --- </td>";
                    else
                        echo "<td> $roww[konserwator] </td>";
                    /** Opcje Usuń - Zmień */
                    echo "<td><form method='POST' action='Katalog.php'>
                            <input type='text' name='action' value='delete' style='display:none'> 
                            <input type='text' name='table' value='dzielo' style='display:none'> 
                            <input type='text' name='ID' value='id_dziela' style='display:none'>
                            <input type='number' name='value' value='$roww[id_dziela]' style='display:none'>                               
                            <input type='submit' value='Usuń'>
                            </form>
                            <button onclick=\"getElementsByName('updateDzielo$roww[id_dziela]')[0].style.display='block'\">Zmień</button>
                            <div id='updateAutor' name='updateDzielo$roww[id_dziela]' class='modal'>
                            <form class='modal-content animate' method='POST' action='Katalog.php'>
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
                                <input type='date' name='Data' value='$roww[data_powstania]'>
                                <label for='estymowana_wartosc'><b>Estymowana wartość</b></label>
                                <input type='text' name='estymowana_wartosc' value='$roww[estymowana_wartosc]'>
                                <input type='submit' value='Zmień'>
                                <aside>Zostaw puste wartości w rozwiajnych listach aby nie zmienić wartości w odpowiadających kolumnach</aside>
                            </div>
                            </form></div></td>";
                    $tmpID = $roww[id_dziela];
                }
                echo "</tr>";
            }
            echo "</table>\n";

            echo "<form method='POST' action='Raport.php'>
            <input type='text' name='raport' value='$query' style='display:none'> 
            <input type='submit' value='Raport'>
            </form>";
            
            pg_free_result($result);

        ?>
    </div>
</main>

<?php include '../Footer.php';?>
