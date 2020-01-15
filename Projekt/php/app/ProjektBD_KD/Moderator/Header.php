<!doctype html>
<html>
     <head>
          <meta charset="UTF-8" />
          <title>Baza danych</title>
          <script src='ModMenu.js' defer></script>
          <link rel="stylesheet" href="ModMenu.css" />
          <link rel="stylesheet" href="../style.css" />
	 </head>
<body>

<header>
    <h1>Katalog dzieł sztuki</h1>
</header>

<table id="Menu">
    <tr>
        <td><button class="HeaderBtn" onclick="location.href='../index.php';">Strona główna</button></td>
        <td><button class="HeaderBtn" onclick="location.href='Katalog.php';">Katalog (moderator)</button></td>
        <td><button class="HeaderBtn" onclick="location.href='Moderator.php';">Moderator</button></td>
    </tr>
</table>

<?php include '../conn.php';?>
