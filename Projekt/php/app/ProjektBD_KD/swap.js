// TODO: should be refactor to use display:none <-> dispaly:block elements

var container1innerHTML = ""; //Zmienna przechowująca hyper text interfejsu filtrowania wyników (ograniczenia widoku)

/**
 * @brief Zamienia interfejs filtrowania wyników (ograniczenia widoku) na interfejs sortowania
 */
function swapToOrder()
{
    document.getElementById('container-1').innerHTML = "";
    document.getElementById('container-2').innerHTML =
    "<label for='Autor'><b>Autor</b></label>"+
    "<select name='Autor'>"+
    "    <option value='null'></option>"+
    "    <option value='ASC'>Ascending</option>"+
    "    <option value='DESC'>Descending</option>"+
    "</select>"+
    "<label for='Kraj'><b>Kraj</b></label>"+
    "<select name='Kraj'>"+
    "    <option value='null'></option>"+
    "    <option value='ASC'>Ascending</option>"+
    "    <option value='DESC'>Descending</option>"+
    "</select>"+
    "<label for='Gatunek'><b>Gatunek</b></label>"+
    "<select name='Gatunek'>"+
    "    <option value='null'></option>"+
    "    <option value='ASC'>Ascending</option>"+
    "    <option value='DESC'>Descending</option>"+
    "</select>"+
    "<label for='Rodzaj'><b>Rodzaj</b></label>"+
    "<select name='Rodzaj'>"+
    "    <option value='null'></option>"+
    "    <option value='ASC'>Ascending</option>"+
    "    <option value='DESC'>Descending</option>"+
    "</select>"+
    "<label for='Material'><b>Material</b></label>"+
    "<select name='Material'>"+
    "    <option value='null'></option>"+
    "    <option value='ASC'>Ascending</option>"+
    "    <option value='DESC'>Descending</option>"+
    "</select>"+
    "<label for='Status'><b>Status</b></label>"+
    "<select name='Status'>"+
    "    <option value='null'></option>"+
    "    <option value='ASC'>Ascending</option>"+
    "    <option value='DESC'>Descending</option>"+
    "</select>"+
    "<button type='submit'>Aktualizuj</button>";
}

/**
 * @brief Zamienia interfejs sortowani wyników na filtrowania wyników (ograniczenia widoku)
 */
function swapToShow()
{
    document.getElementById('container-1').innerHTML = container1innerHTML;
    document.getElementById('container-2').innerHTML = "";
}

// Zapisuję hyper text interfejsu filtrowania wyników (ograniczenia widoku)
window.onload = function(){container1innerHTML = document.getElementById('container-1').innerHTML;}