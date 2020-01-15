<!-- Menu moderatora -->
<!-- 
    + Interfejs dodawania, zmieniania i usuwania rekordów z tabel
    + Implemenmtuje modalne formualrze dodawania/usuwania i zmienia rekordów w tabelach
    + Interfej sortowania w doł (descending)
 -->

<!-- Dodaje nowe dzielo -->
<div id='addForm' class='modal'>
    <form class='modal-content animate' method="POST" action='Moderator.php'>
        <div id="container-1" class="container">
            <input type='text' name='action' value='addNewArt' style='display:none'>
            <label for="url_topic"><b>Adres URL obrazu</b></label>
            <input type="text" name="url_topic">
            <label for="Tytul"><b>Nazwa dzieła</b></label>
            <input type="text" name="Tytul">
            <label for="Autor"><b>Autor</b></label>
            <select name="Autor">
                <?php echo getAuthor()?>
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
            <label for="Data"><b>Data</b></label>
            <input type="date" name="Data">
            <button type="submit">Dodaj</button>
        </div>
    </form>
</div>

<!-- Dodaje nowego autora, usuwa i zmienia starego -->
<div id='AuthorForm' class='modal'>
    <?php
        $query = "SELECT * FROM Autor";
        $result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
    
        /* Table with private data */           
        echo "<table class='modal-content animate' border=1 cellspacing=0>\n";
        echo "<tr><th>ID</th><th>Nazwisko Autora</th><th>Kraj pochodzenia</th><th>Opcje</th></tr>";
        while ($roww = pg_fetch_array($result, null, PGSQL_ASSOC)) 
        {
            echo "<tr>\n";

            echo "<td> $roww[id_autora] </td>";
            echo "<td> $roww[nazwa] </td>";
            echo "<td> $roww[kraj] </td>";
            echo "<td> <form method='POST' action='Moderator.php'>
                <div>
                    <input type='text' name='action' value='delete' style='display:none'>
                    <input type='text' name='table' value='Autor' style='display:none'>
                    <input type='text' name='ID' value='id_autora' style='display:none'>
                    <input type='number' name='value' value='$roww[id_autora]' style='display:none'>
                    <input type='submit' value='Usuń'>
                    </div></form>
                <button onclick=\"getElementsByName('updateAutor$roww[id_autora]')[0].style.display='block'\">Zmień</button>
                <div id='updateAutor' name='updateAutor$roww[id_autora]' class='modal'>
                <form class='modal-content animate' method='POST' action='Moderator.php'>
                    <div id='container-1' class='container'>
                    <input type='text' name='action' value='updateAutor' style='display:none'>
                    <input type='text' name='table' value='Autor' style='display:none'>
                    <input type='text' name='ID' value='id_autora' style='display:none'>
                    <input type='number' name='IDvalue' value='$roww[id_autora]' style='display:none'>
                    <input type='text' name='col1' value='nazwa' style='display:none'>
                    <input type='text' name='value1' value='$roww[nazwa]'>
                    <input type='text' name='col2' value='kraj' style='display:none'>
                    <input type='text' name='value2' value='$roww[kraj]'>

                    <input type='submit' value='Zmień'>
                </div>
                </form></div></td>";
          

            echo "</tr>";
        }
        echo "</table>\n";
        pg_free_result($result);
    ?>
    <form class='modal-content animate' method="POST" action='Moderator.php'>
        <div id="container-1" class="container">
            <input type='text' name='action' value='addAuthor' style='display:none'>
            <label for="Nazwa"><b>Nazwisko autora</b></label>
            <input type="text" name="Nazwa">
            <label for="Kraj"><b>Kraj pochodzenia</b></label>
            <input type="text" name="Kraj">
            <button type="submit">Dodaj</button>
        </div>
    </form>
</div>

<!-- Dodaje nowego konserwatora, usuwa i zmienia starego -->
<div id='ConservForm' class='modal'>
    <?php
        $query = "SELECT * FROM Konserwator";
        $result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
    
        /* Table with private data */           
        echo "<table class='modal-content animate' border=1 cellspacing=0>\n";
        echo "<tr><th>ID</th><th>Nazwisko konserwatora</th><th>Opcje</th></tr>";
        while ($roww = pg_fetch_array($result, null, PGSQL_ASSOC)) 
        {
            echo "<tr>\n";

            echo "<td> $roww[id_konserwatora] </td>";
            echo "<td> $roww[nazwa] </td>";
            echo "<td> <form method='POST' action='Moderator.php'>
                <div>
                <input type='text' name='action' value='delete' style='display:none'>
                <input type='text' name='table' value='Konserwator' style='display:none'>
                <input type='text' name='ID' value='id_konserwatora' style='display:none'>
                <input type='number' name='value' value='$roww[id_konserwatora]' style='display:none'>
                <input type='submit' value='Usuń'>
                </div></form>
                <button onclick=\"getElementsByName('updateKonserwator$roww[id_konserwatora]')[0].style.display='block'\">Zmień</button>
                <div id='updateAutor' name='updateKonserwator$roww[id_konserwatora]' class='modal'>
                <form class='modal-content animate' method='POST' action='Moderator.php'>
                    <div id='container-1' class='container'>
                    <input type='text' name='action' value='updateSimple' style='display:none'>
                    <input type='text' name='table' value='Konserwator' style='display:none'>
                    <input type='text' name='ID' value='id_konserwatora' style='display:none'>
                    <input type='number' name='IDvalue' value='$roww[id_konserwatora]' style='display:none'>
                    <input type='text' name='column' value='nazwa' style='display:none'>
                    <input type='text' name='value' value='$roww[nazwa]'>


                    <input type='submit' value='Zmień'>
                </div>
                </form></div></td>";

            echo "</tr>";
        }
        echo "</table>\n";
        pg_free_result($result);
    ?>

    <form class='modal-content animate' method="POST" action='Moderator.php'>
        <div id="container-1" class="container">
            <input type='text' name='action' value='addConserv' style='display:none'>
            <label for="Nazwa"><b>Nazwisko konserwatora</b></label>
            <input type="text" name="Nazwa">
            <button type="submit">Dodaj</button>
        </div>
    </form>
</div>

<!-- Dodaje nowy status, usuwa i zmienia stary -->
<div id='StatusForm' class='modal'>
    <?php
        $query = "SELECT * FROM Status";
        $result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
    
        /* Table with private data */           
        echo "<table class='modal-content animate' border=1 cellspacing=0>\n";
        echo "<tr><th>ID</th><th>Nazwa statusu</th><th>Opcje</th></tr>";
        while ($roww = pg_fetch_array($result, null, PGSQL_ASSOC)) 
        {
            echo "<tr>\n";

            echo "<td> $roww[id_statusu] </td>";
            echo "<td> $roww[status_dziela] </td>";
            echo "<td> <form method='POST' action='Moderator.php'>
                <div>
                <input type='text' name='action' value='delete' style='display:none'>
                <input type='text' name='table' value='status' style='display:none'>
                <input type='text' name='ID' value='id_statusu' style='display:none'>
                <input type='number' name='value' value='$roww[id_statusu]' style='display:none'>
                <input type='submit' value='Usuń'>
                </div></form>
                <button onclick=\"getElementsByName('updateStatus$roww[id_statusu]')[0].style.display='block'\">Zmień</button>
                <div id='updateAutor' name='updateStatus$roww[id_statusu]' class='modal'>
                <form class='modal-content animate' method='POST' action='Moderator.php'>
                    <div id='container-1' class='container'>
                    <input type='text' name='action' value='updateSimple' style='display:none'>
                    <input type='text' name='table' value='Status' style='display:none'>
                    <input type='text' name='ID' value='id_statusu' style='display:none'>
                    <input type='number' name='IDvalue' value='$roww[id_statusu]' style='display:none'>
                    <input type='text' name='column' value='status_dziela' style='display:none'>
                    <input type='text' name='value' value='$roww[status_dziela]'>


                    <input type='submit' value='Zmień'>
                </div>
                </form></div></td>";

            echo "</tr>";
        }
        echo "</table>\n";
        pg_free_result($result);
    ?>

    <form class='modal-content animate' method="POST" action='Moderator.php'>
        <div id="container-1" class="container">
            <input type='text' name='action' value='addStatus' style='display:none'>
            <label for="Nazwa"><b>Status</b></label>
            <input type="text" name="Nazwa">
            <button type="submit">Dodaj</button>
        </div>
    </form>
</div>

<!-- Dodaje nowy material, usuwa i zmienia stary -->
<div id='MaterialForm' class='modal'>
    <?php
        $query = "SELECT * FROM Material";
        $result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
    
        /* Table with private data */           
        echo "<table class='modal-content animate' border=1 cellspacing=0>\n";
        echo "<tr><th>ID</th><th>Nazwa materiału</th><th>Opcje</th></tr>";
        while ($roww = pg_fetch_array($result, null, PGSQL_ASSOC)) 
        {
            echo "<tr>\n";

            echo "<td> $roww[id_materialu] </td>";
            echo "<td> $roww[nazwa] </td>";
            echo "<td> <form method='POST' action='Moderator.php'>
                <div>
                    <input type='text' name='action' value='delete' style='display:none'>
                    <input type='text' name='table' value='Material' style='display:none'>
                    <input type='text' name='ID' value='id_materialu' style='display:none'>
                    <input type='number' name='value' value='$roww[id_materialu]' style='display:none'>
                    <input type='submit' value='Usuń'>
                </div></form>
                <button onclick=\"getElementsByName('updateMaterial$roww[id_materialu]')[0].style.display='block'\">Zmień</button>
                <div id='updateAutor' name='updateMaterial$roww[id_materialu]' class='modal'>
                <form class='modal-content animate' method='POST' action='Moderator.php'>
                    <div id='container-1' class='container'>
                    <input type='text' name='action' value='updateSimple' style='display:none'>
                    <input type='text' name='table' value='Material' style='display:none'>
                    <input type='text' name='ID' value='id_materialu' style='display:none'>
                    <input type='number' name='IDvalue' value='$roww[id_materialu]' style='display:none'>
                    <input type='text' name='column' value='nazwa' style='display:none'>
                    <input type='text' name='value' value='$roww[nazwa]'>


                    <input type='submit' value='Zmień'>
                </div>
                </form></div></td>";

            echo "</tr>";
        }
        echo "</table>\n";
        pg_free_result($result);
    ?>

    <form class='modal-content animate' method="POST" action='Moderator.php'>
        <div id="container-1" class="container">
            <input type='text' name='action' value='addMaterial' style='display:none'>
            <label for="Nazwa"><b>Material</b></label>
            <input type="text" name="Nazwa">
            <button type="submit">Dodaj</button>
        </div>
    </form>
</div>

<!-- Dodaje nową konserwację, usuwa i zmienia starą. Łączy istniejące konesrwacje z konserwatorami -->
<div id='ConservEventForm' class='modal'>
    <?php
        $query = "SELECT DISTINCT kon.*, k.nazwa, dpd.tytul, a.nazwa as autor, a.kraj FROM Konserwacja kon, konserwator k, Konserwator_konserwacja kk, prywatne_dane_obrazu pdo, dane_publiczne_dziela dpd, autor a, dzielo_autor da WHERE kon.id_Konserwacji = kk.id_konserwacji and k.id_konserwatora = kk.id_konserwatora and kon.id_prywatnedo = pdo.id_prywatnedo and pdo.id_dziela = da.id_dziela AND da.id_autora = a.id_autora AND pdo.id_dziela = dpd.id_dziela";
        $result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
              
        echo "<table class='modal-content animate' border=1 cellspacing=0>\n";
        echo "<tr><th>ID konserwacji</th><th>Konserwator</th><th>Data konserwacji</th><th>Typ konserwacji</th><th>Konserwator</th><th>Tytuł</th><th>Autor</th><th>Opcje</th></tr>";
        while ($roww = pg_fetch_array($result, null, PGSQL_ASSOC)) 
        {
            echo "<tr>\n";

            echo "<td> $roww[id_konserwacji] </td>";
            echo "<td> $roww[nazwa] </td>";
            echo "<td> $roww[data] </td>";
            echo "<td> $roww[typ_konserwacji] </td>";
            echo "<td> $roww[tytul] </td>";
            echo "<td> $roww[autor] </td>";
            echo "<td> $roww[kraj] </td>";
            echo "<td> <form method='POST' action='Moderator.php'>
                <div>
                    <input type='text' name='action' value='delete' style='display:none'>
                    <input type='text' name='table' value='konserwacja' style='display:none'>
                    <input type='text' name='ID' value='id_konserwacji' style='display:none'>
                    <input type='number' name='value' value='$roww[id_konserwacji]' style='display:none'>
                    <input type='submit' value='Usuń'>
                </div></form>
                </td>";

            echo "</tr>";
        }
        echo "</table>\n";
        pg_free_result($result);
    ?>

    <form class='modal-content animate' method="POST" action='Moderator.php'>
        <div id="container-1" class="container">
            <input type='text' name='action' value='addConservEvent' style='display:none'>
            <label for="Data"><b>Data</b></label>
            <input type="date" name="Data">
            <label for="Typ_Konserwacji"><b>Typ konseracji</b></label>
            <input type="text" name="Typ_Konserwacji">
            <label for="id_prywatnedo"><b>Dzieło</b></label>
            <select name="id_prywatnedo">
                <?php echo getOptions('DanePrywatne')?>
            </select>
            <button type="submit">Dodaj</button>
        </div>
    </form>
    <form class='modal-content animate' method="POST" action='Moderator.php'>
        <div id="container-1" class="container">
            <input type='text' name='action' value='addConservEventRel' style='display:none'>
            <label for="id_konserwatora"><b>Konserwator</b></label>
            <select name="id_konserwatora">
                <?php echo getOptions('Konserwator')?>
            </select>
            <label for="id_konserwacji"><b>Dzieło</b></label>
            <select name="id_konserwacji">
                <?php echo getOptions('Konserwacja')?>
            </select>
            <button type="submit">Dodaj</button>
        </div>
    </form>
</div>

<!-- Dodaje nowy gatunek, usuwa i zmienia stary -->
<div id='GenreForm' class='modal'>
    <?php
        $query = "SELECT * FROM Gatunek";
        $result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
    
        /* Table with private data */           
        echo "<table class='modal-content animate' border=1 cellspacing=0>\n";
        echo "<tr><th>ID</th><th>Nazwa gatunku</th><th>Opcje</th></tr>";
        while ($roww = pg_fetch_array($result, null, PGSQL_ASSOC)) 
        {
            echo "<tr>\n";

            echo "<td> $roww[id_gatunku] </td>";
            echo "<td> $roww[nazwa] </td>";
            echo "<td> <form method='POST' action='Moderator.php'>
                <div>
                <input type='text' name='action' value='delete' style='display:none'>
                <input type='text' name='table' value='gatunek' style='display:none'>
                <input type='text' name='ID' value='id_gatunku' style='display:none'>
                <input type='number' name='value' value='$roww[id_gatunku]' style='display:none'>
                <input type='submit' value='Usuń'>
                </div></form>
                <button onclick=\"getElementsByName('updateGatunek$roww[id_gatunku]')[0].style.display='block'\">Zmień</button>
                <div id='updateAutor' name='updateGatunek$roww[id_gatunku]' class='modal'>
                <form class='modal-content animate' method='POST' action='Moderator.php'>
                    <div id='container-1' class='container'>
                    <input type='text' name='action' value='updateSimple' style='display:none'>
                    <input type='text' name='table' value='Gatunek' style='display:none'>
                    <input type='text' name='ID' value='id_gatunku' style='display:none'>
                    <input type='number' name='IDvalue' value='$roww[id_gatunku]' style='display:none'>
                    <input type='text' name='column' value='nazwa' style='display:none'>
                    <input type='text' name='value' value='$roww[nazwa]'>


                    <input type='submit' value='Zmień'>
                </div>
                </form></div></td>";

            echo "</tr>";
        }
        echo "</table>\n";
        pg_free_result($result);
    ?>

    <form class='modal-content animate' method="POST" action='Moderator.php'>
        <div id="container-1" class="container">
            <input type='text' name='action' value='addGenre' style='display:none'>
            <label for="Nazwa"><b>Gatunek</b></label>
            <input type="text" name="Nazwa">
            <button type="submit">Dodaj</button>
        </div>
    </form>
</div>

<!-- Dodaje nowy rodzaj, usuwa i zmienia stary -->
<div id='TypeForm' class='modal'>
    <?php
        $query = "SELECT * FROM Rodzaj";
        $result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
    
        /* Table with private data */           
        echo "<table class='modal-content animate' border=1 cellspacing=0>\n";
        echo "<tr><th>ID</th><th>Nazwa rodzaju dzieła</th><th>Opcje</th></tr>";
        while ($roww = pg_fetch_array($result, null, PGSQL_ASSOC)) 
        {
            echo "<tr>\n";

            echo "<td> $roww[id_rodzaju] </td>";
            echo "<td> $roww[nazwa] </td>";
            echo "<td> <form method='POST' action='Moderator.php'>
                <div>
                <input type='text' name='action' value='delete' style='display:none'>
                <input type='text' name='table' value='Rodzaj' style='display:none'>
                <input type='text' name='ID' value='id_rodzaju' style='display:none'>
                <input type='number' name='value' value='$roww[id_rodzaju]' style='display:none'>
                <input type='submit' value='Usuń'>
                </div></form>
                <button onclick=\"getElementsByName('updateRodzaj$roww[id_rodzaju]')[0].style.display='block'\">Zmień</button>
                <div id='updateAutor' name='updateRodzaj$roww[id_rodzaju]' class='modal'>
                <form class='modal-content animate' method='POST' action='Moderator.php'>
                    <div id='container-1' class='container'>
                    <input type='text' name='action' value='updateSimple' style='display:none'>
                    <input type='text' name='table' value='Rodzaj' style='display:none'>
                    <input type='text' name='ID' value='id_rodzaju' style='display:none'>
                    <input type='number' name='IDvalue' value='$roww[id_rodzaju]' style='display:none'>
                    <input type='text' name='column' value='nazwa' style='display:none'>
                    <input type='text' name='value' value='$roww[nazwa]'>


                    <input type='submit' value='Zmień'>
                </div>
                </form></div></td>";

            echo "</tr>";
        }
        echo "</table>\n";
        pg_free_result($result);
    ?>

    <form class='modal-content animate' method="POST" action='Moderator.php'>
        <div id="container-1" class="container">
            <input type='text' name='action' value='addType' style='display:none'>
            <label for="Nazwa"><b>Rodzaj</b></label>
            <input type="text" name="Nazwa">
            <button type="submit">Dodaj</button>
        </div>
    </form>
</div>

<!-- Przyciski urchamiające formularze modalne do dodawania rekordów -->
<table id='ModMenu'>
    <tr>
        <td><button onclick='toggleAddForm()'>Dodaj Dzieło</button></td>
        <td><button onclick='toggleConservForm()'>Dodaj Konserwatora</button></td>
        <td><button onclick='toggleAuthorForm()'>Dodaj Autora</button></td>
        <td><button onclick='toggleStatusForm()'>Dodaj Status</button></td>
        <td><button onclick='toggleMaterialForm()'>Dodaj Material</button></td>
        <td><button onclick='toggleConservEventForm()'>Dodaj zdarzenie konserwacji</button></td>
        <td><button onclick='toggleGenreForm()'>Dodaj Gatunek</button></td>
        <td><button onclick='toggleTypeForm()'>Dodaj Rodzaj</button></td>
    </tr>
    <tr>
        <th colspan="6">Sortuj wg:</th>
    </tr>
    <tr>
        <td><form method='GET' action='Moderator.php'> 
            <input type='text' name='privateView' value='id_dziela' style='display:none'>
            <input type='submit' value='ID'>
            </form>
        </td>
        <td><form method='GET' action='Moderator.php'> 
            <input type='text' name='privateView' value='Autor' style='display:none'>
            <input type='submit' value='Autor'>
            </form>
        </td>
        <td><form method='GET' action='Moderator.php'> 
            <input type='text' name='privateView' value='Kraj' style='display:none'>
            <input type='submit' value='Kraj'>
            </form>
        </td>
        <td><form method='GET' action='Moderator.php'> 
            <input type='text' name='privateView' value='status' style='display:none'>
            <input type='submit' value='Status'>
            </form>
        </td>
        <td><form method='GET' action='Moderator.php'> 
            <input type='text' name='privateView' value='estymowana_wartosc' style='display:none'>
            <input type='submit' value='Wartość'>
            </form>
        </td>
        <td><form method='GET' action='Moderator.php'> 
            <input type='text' name='privateView' value='LiczbaKonserwacji' style='display:none'>
            <input type='submit' value='LiczbaKonserwacji'>
            </form>
        </td>
    </tr>
</table>




