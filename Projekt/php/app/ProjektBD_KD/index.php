<?php include 'Header.php';?>

<main>

    Prezentujemy katalog dzieł sztuki.<br>
    Każdy może by artystą.<br>
    Chyba.<br>
    <div class="index-main">
    Obecnie w katalogu znajduję się:<br>
    
    --Dzieł: <b style="color: #7a6188">
<?php echo getCount("Dzielo"); ?>
    </b><br>
    ----od <b style="color: #7a6188">
<?php echo getCount("Autor"); ?> </b>
    twórców<br>

    </div>
</main>

<?php include 'Footer.php';?>
