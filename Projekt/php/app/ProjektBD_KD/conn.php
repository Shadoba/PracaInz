<?php
/* połączenie z bazą */
$dbconn = pg_pconnect("host=postgresdb port=5432 dbname=kddb user=user password=password")
    or die('Nie można nawiązac połączenia: ' . pg_last_error());

/**
 * @ brief Wyświetla alert ECMAScript
 * @ parameter $msg to co wyswietli w alercie 
 */
function alert($msg) 
{
	echo "<script type='text/javascript'>alert('$msg');</script>";
}

/**
 * @brief zwraca maxymalną wartość z tabeli
 * //TODO: unused
 */
function getMax($table, $column)
{
	$query = 'SELECT max('.$column.') FROM '.$table;
	$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
	$row = pg_fetch_row($result);
	return $row[0];
}

/**
 * @brief zwraca ilosc rekordow  w tabeli 
 * @parameter [String] nazwa tabeli
 */
function getCount($table)
{
	$query = 'SELECT COUNT(*) FROM '.$table;
	$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
	$row = pg_fetch_row($result);
	return $row[0];
}

/**
 * @brief zwaraca w postaci html dostępne opcje w tabelach
 * @parameter [String] nazwa tabeli
 */
function getOptions($tableName)
{
	$sqlOptions = '<option value="null" selected> </option>';
	switch($tableName)
	{
		case 'DanePrywatne';
			$sqlQuerry = pg_query("SELECT DISTINCT pdo.id_prywatnedo, dpd.tytul, a.nazwa AS autor, a.kraj FROM prywatne_dane_obrazu pdo, dane_publiczne_dziela dpd, autor a, dzielo_autor da WHERE pdo.id_dziela = da.id_dziela AND da.id_autora = a.id_autora AND pdo.id_dziela = dpd.id_dziela;");
			while ($roww = pg_fetch_assoc($sqlQuerry)) 
			{
				$sqlOptions .= '<option value="'.htmlspecialchars($roww['id_prywatnedo']).'">'.htmlspecialchars($roww['tytul']).', '.htmlspecialchars($roww['autor']).', '.htmlspecialchars($roww['kraj']).'</option>';
			}
			break;
		case 'Status';
			$sqlQuerry = pg_query("SELECT * FROM Status");
			while ($roww = pg_fetch_assoc($sqlQuerry)) 
			{
				$sqlOptions .= '<option value="'.htmlspecialchars($roww['id_statusu']).'">'.htmlspecialchars($roww['status_dziela']).'</option>';
			}
			break;
		case 'Rodzaj';
			$sqlQuerry = pg_query("SELECT * FROM Rodzaj");
			while ($roww = pg_fetch_assoc($sqlQuerry)) 
			{
				$sqlOptions .= '<option value="'.htmlspecialchars($roww['id_rodzaju']).'">'.htmlspecialchars($roww['nazwa']).'</option>';
			}
			break;
		case 'Material';
			$sqlQuerry = pg_query("SELECT * FROM Material");
			while ($roww = pg_fetch_assoc($sqlQuerry)) 
			{
				$sqlOptions .= '<option value="'.htmlspecialchars($roww['id_materialu']).'">'.htmlspecialchars($roww['nazwa']).'</option>';
			}
			break;
		case 'Gatunek';
			$sqlQuerry = pg_query("SELECT * FROM Gatunek");
			while ($roww = pg_fetch_assoc($sqlQuerry)) 
			{
				$sqlOptions .= '<option value="'.htmlspecialchars($roww['id_gatunku']).'">'.htmlspecialchars($roww['nazwa']).'</option>';
			}
			break;
		case 'Autor';
			$sqlQuerry = pg_query("SELECT ID_Autora, Nazwa FROM Autor");
			while ($roww = pg_fetch_assoc($sqlQuerry)) 
			{
				$sqlOptions .= '<option value="'.htmlspecialchars($roww['id_autora']).'">'.htmlspecialchars($roww['nazwa']).'</option>';
			}
			break;
		case 'Kraj';
			$sqlQuerry = pg_query("SELECT Kraj FROM Autor");
			while ($roww = pg_fetch_assoc($sqlQuerry)) 
			{
				$sqlOptions .= '<option value="'.htmlspecialchars($roww['kraj']).'">'.htmlspecialchars($roww['kraj']).'</option>';
			}
			break;
		case 'Konserwator';
			$sqlQuerry = pg_query("SELECT * FROM Konserwator");
			while ($roww = pg_fetch_assoc($sqlQuerry)) 
			{
				$sqlOptions .= '<option value="'.htmlspecialchars($roww['id_konserwatora']).'">'.htmlspecialchars($roww['nazwa']).'</option>';
			}
			break;
		case 'Konserwacja';
			$sqlQuerry = pg_query("SELECT DISTINCT k.*, dpd.tytul, a.nazwa FROM Konserwacja k, prywatne_dane_obrazu pdo, dane_publiczne_dziela dpd, dzielo_autor da, autor a where k.id_prywatnedo = pdo.id_prywatnedo and pdo.id_dziela = da.id_dziela and da.id_autora = a.id_autora and pdo.id_dziela = dpd.id_dziela");
			while ($roww = pg_fetch_assoc($sqlQuerry)) 
			{
				$sqlOptions .= '<option value="'.htmlspecialchars($roww['id_konserwacji']).'">'.htmlspecialchars($roww['data']).', '.htmlspecialchars($roww['tytul']).', '.htmlspecialchars($roww['nazwa']).'</option>';
			}
			break;
		default:
			return null;
	}

	return $sqlOptions;
}

/**
 * @brief zwaraca opcje wpostaci html z tabeli Autor
 */
function getAuthor()
{
	$sqlOptions = '<option value="null" selected> </option>';
	$sqlQuerry = pg_query("SELECT * FROM Autor");
	while ($roww = pg_fetch_assoc($sqlQuerry)) 
	{
		$sqlOptions .= '<option value="'.htmlspecialchars($roww['id_autora']).'">'.htmlspecialchars($roww['nazwa']).','.htmlspecialchars($roww['kraj']).'</option>';
	}
	return $sqlOptions;
}

?>
