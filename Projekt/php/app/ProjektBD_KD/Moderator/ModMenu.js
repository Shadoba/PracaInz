/**
 * @brief wyswietla modlany formularz dodawania dziela
 */
function toggleAddForm()
{
    var addForm = document.getElementById('addForm');
    addForm.style.display='block';
}

/**
 * @brief wyswietla modlany formularz dodawania konserwacji
 */
function toggleConservForm()
{
    var addConserv = document.getElementById('ConservForm');
    addConserv.style.display='block';
}

/**
 * @brief wyswietla modlany formularz dodawania autora
 */
function toggleAuthorForm()
{
    var addAuthor = document.getElementById('AuthorForm');
    addAuthor.style.display='block';
}


/**
 * @brief wyswietla modlany formularz dodawania statusu
 */
function toggleStatusForm()
{
    var addStatus = document.getElementById('StatusForm');
    addStatus.style.display='block';
}

/**
 * @brief wyswietla modlany formularz dodawania materialu
 */
function toggleMaterialForm()
{
    var addMaterial = document.getElementById('MaterialForm');
    addMaterial.style.display='block';
}

/**
 * @brief wyswietla modlany formularz dodawania konserwatora do konserwacji
 */
function toggleConservEventForm()
{
    var addConservEvent = document.getElementById('ConservEventForm');
    addConservEvent.style.display='block';
}

/**
 * @brief wyswietla modlany formularz dodawania gatunku
 */
function toggleGenreForm()
{
    var addGenre = document.getElementById('GenreForm');
    addGenre.style.display='block';
}

/**
 * @brief wyswietla modlany formularz dodawania rodzaju
 */
function toggleTypeForm()
{
    var addType = document.getElementById('TypeForm');
    addType.style.display='block';
}

// Get the modal
var modal = document.getElementsByClassName('modal');

// Wyłączenie modalnego formularz kiedy klinie się poza niego
window.onclick = function(event) {
    for(element in modal)
        if (event.target == modal[element]) {
            modal[element].style.display = "none";
        }
}

