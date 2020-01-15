<!doctype html>
<html>
     <head>
          <meta charset="UTF-8" />
		  <link rel="stylesheet" href="style.css" type="text/css" />
          <title>Baza danych</title>
	 </head>
<body>

<header>
    <h1>Katalog dzieł sztuki</h1>
</header>

<table id="Menu">
    <tr>
        <td><button class="HeaderBtn" onclick="location.href='index.php';">Strona główna</button></td>
        <td><button class="HeaderBtn" onclick="location.href='Katalog.php';">Katalog</button></td>
        <td><button class="HeaderBtn" onclick="location.href='Moderator/Moderator.php';">Login</button></td>
    </tr>
</table>

<?php include 'conn.php';?>
