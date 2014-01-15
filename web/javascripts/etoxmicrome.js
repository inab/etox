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

function addEvidenciaEntidadForm(collectionHolder, $newLinkLi, $entidadType) {
    // Get the data-prototype explained earlier
    if ($entidadType=="compound"){
        // get the new index
        var index = collectionHolder.data('index');
        var prototype = '<a id="chebiID___name__" onclick="getChebiIDs(\'/app_dev.php/get_chebids/\', __name__);" name="chebiID___name__" href="#">(Search ChebiIDs)</a> \
                    <div id="text___name__" class="chebi_links"></div> \
                    <li> \
                        <div class="form_row"> \
                            <div id="etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name__"> \
                                <div class="form_row"> \
                                    <input id="etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name___textminingName" type="text" value="" required="required"  \ name="etoxmicrome_evidenciabundle_evidenciatype[evidenciaEntidad][__name__][textminingName]" placeholder="Name of Compound"> \
                                </div> \
                                <div class="form_row"> \
                                    <div id="etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name___compuesto"> \
                                        <div class="form_row"> \
                                            <input id="etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name___compuesto_chebiId" class="ui-droppable" type="text" required="required"  name="etoxmicrome_evidenciabundle_evidenciatype[evidenciaEntidad][__name__][compuesto][chebiId]"  placeholder="ChebiId"> \
                                        </div> \
                                        <div class="form_row"> \
                                            <select id="etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name___compuesto_inputOutput" required="required"  \ name="etoxmicrome_evidenciabundle_evidenciatype[evidenciaEntidad][__name__][compuesto][inputOutput]"> \
                                                <option value="">Select</option> \
                                                <option value="input">Input</option> \
                                                <option value="output">Output</option> \
                                            </select> \
                                        </div> \
                                    </div> \
                                </div> \
                            </div> \
                        </div> \
                    </li> ';
        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        collectionHolder.data('index', index + 1);
        // Display the form in the page in an li, before the "Add a tag" link li
        var $newFormLi = $('New entity: <li></li>').append(newForm);
        $newLinkLi.before($newFormLi);
        addEvidenciaEntidadFormDeleteLink($newFormLi);
        $selectEvidenciaEntidadType.val('').attr('selected',true);
        $('a[id^="chebiID_"]').on('click', function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();
        });
        $('input[id$="_compuesto_chebiId"]').droppable( {
            drop: handleDropEventCompounds
        } );
    }

    else if($entidadType=="organism"){
        var index = collectionHolder.data('index');
        var prototype = '<a id="taxId___name__" onclick="getTaxId(\' /scripts/returnTaxonomy.py/ \', __name__, \'fromInputAdding\');" name="taxId___name__" href="#">(Search taxId)</a> \
                <div id="text___name__" class="taxId_links"></div> \
                <li> \
                    <div class="form_row"> \
                        <div id="etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name__"> \
                            <div class="form_row"> \
                                <input id="etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name___textminingName" type="text" value="" required="required"  \ name="etoxmicrome_evidenciabundle_evidenciatype[evidenciaEntidad][__name__][textminingName]" placeholder="Name of Organism"> \
                            </div> \
                            <div class="form_row"> \
                                <div id="etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name___organismo"> \
                                    <div class="form_row"> \
                                        <input id="etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name___organismo_idNCBI" class="ui-droppable" type="text" value="" required="required"  \ name="etoxmicrome_evidenciabundle_evidenciatype[evidenciaEntidad][__name__][organismo][idNCBI]" placeholder="idNCBI"> \
                                    </div> \
                                </div> \
                            </div> \
                        </div> \
                    </div> \
                </li> \
                ';
        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        collectionHolder.data('index', index + 1);
        // Display the form in the page in an li, before the "Add a tag" link li
        var $newFormLi = $('New entity: <li></li>').append(newForm);
        $newLinkLi.before($newFormLi);
        addEvidenciaEntidadFormDeleteLink($newFormLi);
        $selectEvidenciaEntidadType.val('').attr('selected',true);
        $('a[id^="taxId_"]').on('click', function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();
        });
        $('a[id^="taxIdPopup_"]').popupWindow( {
            centerScreen:1,
            scrollbars:1,
            width: 835,
            height: 740
        } );
        $('.draggable').draggable( {
            cursor: 'move',
            containment: 'document',
            helper: 'clone'
        } );
        $('input[id$="_organismo_idNCBI"]').droppable( {
            drop: handleDropEventOrganisms
        } );
    }
    else if($entidadType=="enzyme"){
         // get the new index
        var index = collectionHolder.data('index');
        var prototype = '<br/>To search the Uniprot ID we need the name of the specie:<br/> \
            <input id="textminingOrganismName___name__" type="text" placeholder="e.g. Homo sapiens"> \
            <a onclick="getTaxId(\'/scripts/returnTaxonomy.py\',__name__, \'fromSearch\')" name="taxId___name__" href="#">(Search taxId)</a> \
            <div id="text___name__" class="taxId_links"></div> \
            <input id="taxId___name__" class="ui-droppable" type="text" placeholder="drag here the taxon id"> \
            <a onclick="getUniprotIds(\'/scripts/returnUniprotIds.py\',\'__name__\', \'fromInput\')" name="taxId___name__" href="#">(Search UniProtId)</a> \
            <div id="textUnitproId___name__" class="uniprotId_links"></div> \
            <li> \
                <div class="form_row"> \
                    <div id="etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name__"> \
                        <div class="form_row"> \
                            <input id="etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name___textminingName" name="etoxmicrome_evidenciabundle_evidenciatype[evidenciaEntidad][__name__][textminingName]" required="required" type="text" placeholder="Name of enzyme"> \
                        </div> \
                        <div class="form_row"> \
                            <div id="etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name___enzima"> \
                                <div class="form_row"> \
                                    <input id="etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name___enzima_idUniprot" name="etoxmicrome_evidenciabundle_evidenciatype[evidenciaEntidad][__name__][enzima][idUniprot]" required="required" type="text" placeholder="Drop here UniProt IDs"> \
                                </div> \
                                <div class="form_row"> \
                                    <div id="etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name___enzima_proteina" data-prototype="<div class=&quot;form_row&quot;><div id=&quot;etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name___enzima_proteina___name__&quot;><div class=&quot;form_row&quot;><input type=&quot;text&quot; id=&quot;etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name___enzima_proteina___name___idOrganismNCBI&quot; name=&quot;etoxmicrome_evidenciabundle_evidenciatype[evidenciaEntidad][__name__][enzima][proteina][__name__][idOrganismNCBI]&quot; required=&quot;required&quot; /></div><div class=&quot;form_row&quot;><input type=&quot;text&quot; id=&quot;etoxmicrome_evidenciabundle_evidenciatype_evidenciaEntidad___name___enzima_proteina___name___idUniprot&quot; name=&quot;etoxmicrome_evidenciabundle_evidenciatype[evidenciaEntidad][__name__][enzima][proteina][__name__][idUniprot]&quot; required=&quot;required&quot; /></div></div></div>"> \
                                    </div> \
                                </div> \
                            </div> \
                        </div> \
                    </div> \
                </div> \
            </li>';
        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        collectionHolder.data('index', index + 1);
        // Display the form in the page in an li, before the "Add a tag" link li
        var $newFormLi = $('New entity: <li></li>').append(newForm);
        $newLinkLi.before($newFormLi);
        addEvidenciaEntidadFormDeleteLink($newFormLi);
        $selectEvidenciaEntidadType.val('').attr('selected',true);

        $('a[name^="taxId_"]').on('click', function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();
        });
        $('a[id^="taxIdPopup_"]').popupWindow( {
            centerScreen:1,
            scrollbars:1,
            width: 835,
            height: 740
        } );
        $('.draggable').draggable( {
            cursor: 'move',
            containment: 'document',
            helper: 'clone'
        } );
        $('input[id^="taxId_"]').droppable( {
            drop: handleDropEventOrganisms
        } );
    }
}

function addSelectEvidenciaEntidadType($newLinkLi, $selectEvidenciaEntidadType) {
    $newLinkLi.append($selectEvidenciaEntidadType);
}

var collectionHolder = $('ul.evidenciaEntidad-list');
// setup an "add a tag" link
var $addEvidenciaEntidadLink = $('<a href="#" class="add_evidenciaEntidad_link">Add a new entity</a>');
var $newLinkLi = $('<li></li>').append($addEvidenciaEntidadLink);

var $selectEvidenciaEntidadType = $("<br/><select><option value='' selected='selected'></option><option value='compound'>Compound</option><option value='enzyme'>Enzyme</option><option value='organism'>Organism</option></select>");




jQuery(document).ready(function() {

    // add a delete link to all of the existing tag form li elements
    collectionHolder.find('li').each(function() {
        addEvidenciaEntidadFormDeleteLink($(this));
    });

    // add the "add an entity" anchor and li to the tags ul
    collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    var counter = collectionHolder.data('index', collectionHolder.find('input[id$="_textminingName"]').length);
    $addEvidenciaEntidadLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        addSelectEvidenciaEntidadType($newLinkLi, $selectEvidenciaEntidadType);

    });

    $selectEvidenciaEntidadType.on('change', function(e) {
        // prevent the link from creating a "#" on the URL
        $selected=$(this).val();
        if($selected==""){
            alert("Please, select the type of the new entity");

        }
        else{
            // add a new evidenciaEntidad form (see next code block)
            addEvidenciaEntidadForm(collectionHolder, $newLinkLi, $selected);
        }
    });

    $('a[id^="chebiID_"]').on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
    });
    $('a[id^="taxId_"]').on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
    });
    $('a[name^="taxId_"]').on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
    });


});