// Get the ul that holds the collection of evidenciaEntidad


function addEvidenciaEntidadFormDeleteLink($evidenciaEntidadFormLi) {
    var $removeFormA = $('<a href="#">Delete this entity</a>');
    $evidenciaEntidadFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $evidenciaEntidadFormLi.remove();
    });
}

function addEvidenciaEntidadForm(collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = collectionHolder.data('prototype');

    // get the new index
    var index = collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('EntityFound: <li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addEvidenciaEntidadFormDeleteLink($newFormLi);
}

var collectionHolder = $('ul.evidenciaEntidad-list');
// setup an "add a tag" link
var $addEvidenciaEntidadLink = $('<a href="#" class="add_evidenciaEntidad_link">Add a new entity</a>');
var $newLinkLi = $('<li></li>').append($addEvidenciaEntidadLink);





jQuery(document).ready(function() {

    // add a delete link to all of the existing tag form li elements
    collectionHolder.find('li').each(function() {
        addEvidenciaEntidadFormDeleteLink($(this));
    });

    // add the "add an entity" anchor and li to the tags ul
    collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    var counter = collectionHolder.data('index', collectionHolder.find('input[id^="etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad"]').length);
    $addEvidenciaEntidadLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new evidenciaEntidad form (see next code block)
        addEvidenciaEntidadForm(collectionHolder, $newLinkLi);
    });
    $('a[id^="chebiID_"]').on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
    });
    $('a[id^="taxId_"]').on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
    });
});