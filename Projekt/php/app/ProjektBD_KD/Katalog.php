<!-- Katalog moderatora -->
<!-- 
    + Korzysta z widoku public viewView -> widoczne publiczne informacje dla danego dzieła
    + Tylko wyświetla, może sortwać i filtrować
    + Korzysta z funkcjonalności plików:
    +++ Header.php
    +++ conn.php
    +++ swap.js
    +++ endconn.php
    +++ footer.php
 -->

<?php include 'Header.php';?>

<main>
    <nav>
        <!-- swap.js odpowiada z zmiane opcji Pokaż/sortuj -->
        <script src="swap.js"></script>
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
            <div id="container-2" class="container">
            </div>
        </form>
    </nav>

    <div class="Tabela">
        <?php
        /**
         * @brief Generuje widok tabeli publicView z uwzględnieniem ograniczeń lub kryterium sortowania
         */
            $query = "SELECT DISTINCT pv.* FROM publicView pv, rodzaj r, material m, dzielo_autor da, autor a, gatunek g, status s";
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                if($_POST['ShowOrder'] === 'Pokaż')//Ogranicza widok
                {
                    $anyFilterActive = false;
                    foreach($_POST as $key => $value)
                    {
                        if($value != 'null' && !empty($value) && $key != 'ShowOrder')
                        {
                            if($anyFilterActive == false)//Klazula WHERE jest dokładana dokłądnie raz
                                $query .= " WHERE";
                                
                            $anyFilterActive = true; //Sprawdza czy jakiś filtr został użyty
                            if($key == 'Autor')
                                $query .= " pv.id_dziela = (SELECT DA.id_dziela FROM Dzielo_Autor DA
                                WHERE DA.ID_Autora =".$value.")";
                            elseif($key == 'Kraj')
                                $query .= ' da.id_dziela = pv.id_dziela and DA.ID_Autora = A.ID_Autora AND A.Kraj = \''.$value.'\'';
                            elseif($key == 'Gatunek')
                                $query .= " g.nazwa = pv.gatunek and g.id_gatunku = ".$value;  
                            elseif($key == 'Rodzaj')
                                $query .= " r.nazwa = pv.rodzaj and r.id_Rodzaju = ".$value;  
                            elseif($key == 'Material')
                                $query .= " m.nazwa = pv.material and m.id_materialu = ".$value;  
                            elseif($key == 'Status')
                                $query .= " s.status_dziela = pv.status and s.id_statusu = ".$value;
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

            echo "<table border=1 cellspacing=0>\n";
            echo "<tr><th>Miniaturka</th><th>Tytuł</th><th>Autor</th><th>Kraj</th><th>Gatunek</th><th>Rodzaj</th><th>Material</th><th>Data wykonania</th><th>Status</th></tr>";

            while ($roww = pg_fetch_array($result, null, PGSQL_ASSOC)) 
            {
                echo "<tr>\n";
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
                echo "</tr>";
            }
            echo "</table>\n";

            echo "<form method='POST' action='Moderator/Raport.php'>
            <input type='text' name='raport' value='$query' style='display:none'> 
            <input type='submit' value='Raport'>
            </form>";

            pg_free_result($result);

        ?>
    </div>
</main>

<?php include 'Footer.php';?>
