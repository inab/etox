Here it is available different dictionaries used to build up the LimTox System.
Every file corresponds with a specific dictionary. Since JSON format file do not
allow the inclusion of comments, you can find below the explanation for each
dictionary on this repository.

## Liver Markers: [liver_marker.json](./liver_marker.json.gz)

This dictionary was used for biochemical liver marker entity mentions and
database grounding. In addition to specific liver marker entities a commonly
used unspecific marker term was included  in the gazetteer.

	Available fields are:
	1. "marker_identifier":    "unspecific term, Compound Id or UniProt Accession",
	2. "marker_namespace":     "It make reference to the namespace/entry name for"
	                           "the annotated marker",
	3. "marker_type_name":     "It could take two values: '1' corresponds to marker"
	                           "name, '0' corresponds to stop names of non-marker"
	                           "names whose abbreviations/acronyms resemble marker"
	                           "symbols (these were used to disambiguate marker "
	                           "from non marker symbols)"
	4. "marker_full_name":     "string containing the full marker name"
	5. "concept_namespace":    "Concept namespace - this is set to 'liver_marker'"
	6. "marker_normalization": "Used to normalize the biological specimen and it"
	                           "could take two values: '9606' which corresponds to"
	                           "Human, and 'compound' which is species independent"

## Chemical Entities: [chemical_entity.json](./chemical_entity.json.gz)

This dictionary is the LimTox chemical entity gazetteer. It contains data
used for chemical entity database grounding and mapping to structural
information.

	Available fields are - many of its names are self-descriptive
	01. "Chemical_name"
	02. "ChemIDplus_id"
	03. "ChEBI_id"
	04. "CAS_registry"
	05. "PubChem_compound_id"
	06. "PubChem_substance_id"
	07. "IUPAC_International_Chemical_id": "It corresponds to InChI identifiers"
	08. "Drugback_id"
	09. "Human_metabolome_id"
	10. "KEGG_compound_id"
	11. "KEGG_drug_id"
	12. "MeSH_substance_id"
	13. "numb_links_to_external_dbs":      "It makes reference to the number of"
	                                       "databases to which the chemical name"
	                                       "can be linked"
	14. "SMILES":                          "It corresponds to 'simplified molecular-"
	                                       "input line-entry system' (SMILES)"
	15. "convertable_to_structure":        "It indicates whether the chemical name"
	                                       "could be successfully converted into a"
	                                       "structure"

## Chemical MeSHs: [chemical_mesh.json](./chemical_mesh.json.gz)

This dictionary contains the Chemical MeSH terms used for indexing PubMED
abstracts in LimTox.

	Available fields are:
	1. "Chemical_concept_name": "Name for the Chemical entity"
	2. "Chemical_db_id":        "DB identifier in case is available. Otherwise 'NA'"
	3. "MeSH":                  "Unique identifier (UI) for the chemical entity"

## P450 Cytochromes: [p450_cytochrome.json](./p450_cytochrome.json.gz)

This dictionary contains P450 Cytochromes \(CYPs\) canonical names and
hierarchical name structure used in LimTox. This data was used for the
entity names recognition for P450 CYPs exploiting their naming structure.

	Available fields are:
	1. "cytochrome_canonical_symbol": "CYP canonical name symbol"
	2. "cytochrome_canonical_root":   "CYPs canonical root form/stem"
	3. "cytocrome_family_id":         "CYPs family identifier"
	4. "cytocrome_subfamily_id":      "CYPs  subfamily letters"
	5. "cytocrome_protein_id":        "CYPs  protein identifier"

## Hepatotoxicity: [hepatotoxicity.json](./hepatotoxicity.json.gz)

This dictionary contains the LimTox gazetteer for the adverse liver effect
terms/phrases. It contains specific data for adverse liver effect, drug-
induced liver injuries \(DILIs\), and hepatotoxicity terms and concepts
grounding.

	Available fields are:
	01. "mapped":                      "Indicates whether it is possible a direct"
	                                   "concept grounding or not"
	02. "original_entry":              "Original Hepatoxicity, DILI or adverse liver"
	                                   "effect term/phrase"
	03. "stemmed_entry":               "Stemmed (lower case version) Hepatoxicity,"
	                                   "DILI or adverse liver effect term/phrase"
	04. "speech_entry":                "Hepatoxicity, DILI or adverse liver effect"
	                                   "term/phrase part of speech (POS) tagging"
	05. "EFPIA_mapping_id":            "EFPIA concept identifier mapping"
	06. "COSTART_concept":             "COSTART concept hit"
	07. "MedDRA_mapping_id":           "MedDRA concept identifier mapping"
	08. "MPheno_mapping_id":           "MPheno concept identifier mapping"
	09. "adverse_events_mapping_id":   "Ontology of Adverse Events (OAE) concept"
	                                   "identifier mapping"
	10. "disease_ontology_mapping_id": "Disease Ontology concept identifier mapping"
	                                   "(DOID)"
	11. "gemina_sympton_mapping_id":   "Gemina symptom concept identifier mapping"
	12. "human-phenotype_mapping_id":  "Human-phenotype (HP) concept identifier"
	                                   "mapping"
	13. "mouse_pathology_mapping_id":  "Mouse Pathology Ontology concept identifier"
	                                   "mapping"
	14. "mesh_omim_mapping_id":        "MESH_OMIM concept identifier mapping"
	15. "polysearch_mapping_id":       "PolySearch concept identifier mapping"
	16. "etox_mapping_id":             "eTOX ontology concept identifier mapping"

## LimTox Adverse Pattern Extraction: [limtox_adverse_pattern.json](./limtox_adverse_pattern.json.gz)

This dictionary contains the LimTox patterns collection used for the pattern-
based extraction of associations of chemical entities **\[SUBSTANCE\]**, to adverse
events **\[ADVERSE_EFFECT\]** e.g. drug-induced liver injuries \(DILIs\)

	Available fields are:
	1. "adverse_pattern_id":   "LIMTOX adverse event pattern identifier"
	2. "adverse_pattern":      "LIMTOX adverse event pattern string"
	3. "adverse_pattern_norm": "LIMTOX adverse event pattern string normalized"
	                           "version (GENIA tagger stemming)"
	4. "pattern_length":       "Pattern token length"

## LimTox CYPs Substrate Pattern Extraction: [limtox_cyps_pattern.json](./limtox_cyps_pattern.json.gz)

This dictionary contains the LimTox P450 Cytochromes \(CYPs\) substrate/product
association extraction pattern set. This collection of patterns was used for
the pattern-based substrate/product relation extraction of chemical entity
**\[SUBSTANCE\]** associations to P450 CYPs **\[P450_CYPS\]**

	Available fields are:
	1. "substrate_pattern_id":   "LIMTOX substrate/product relation pattern"
	                             "identifier"
	2. "substrate_pattern":      "LIMTOX substrate/product relation pattern string"
	3. "substrate_pattern_norm": "LIMTOX substrate/product relation pattern string"
	                             "normalized version (GENIA tagger stemming)"
	4. "pattern_length":         "Pattern token length"

## LimTox Substance's Cellular Locations Pattern Extraction: [limtox_location_pattern.json](./limtox_location_pattern.json.gz)

This dictionary contains the LimTox substances location association
extraction pattern set. This collection of patterns was used for the
pattern-based inhibition substance location extraction of chemical entity
**\[SUBSTANCE\]** associations to cellular locations **\[LOCATION\]**

	Available fields are:
	1. "location_pattern_id":   "LIMTOX substance location relation pattern"
	                            "identifier"
	2. "location_pattern":      "LIMTOX substance location relation pattern string"
	3. "location_pattern_norm": "LIMTOX substance location relation pattern string"
	                            "normalized version (GENIA tagger stemming)"
	4. "pattern_length":        "Pattern token length"

## LimTox Protein-Protein Interactions Pattern extraction: [limtox_protein_interactions_pattern.json](./limtox_protein_interactions_pattern.json.gz)

This dictionary contains the LimTox protein-protein interactions extraction
pattern set. This collection of patterns was used for the pattern-based
protein-protein interaction extraction of proteins or substances **\[SUBSTANCE\]**

	Available fields are:
	1. "proteins_interaction_pattern_id":   "LIMTOX protein-protein interaction"
	                                        "relation pattern identifier"
	2. "proteins_interaction_pattern":      "LIMTOX protein-protein interaction"
	                                        "relation pattern string"
	3. "proteins_interaction_pattern_norm": "LIMTOX protein-protein interaction"
	                                        "relation pattern string normalized"
	                                        "version (GENIA tagger stemming)"
	4. "pattern_length":                    "Pattern token length"

## LimTox Markers Pattern extraction: [limtox_marker_pattern.json](./limtox_marker_pattern.json.gz)

This dictionary contains the LimTox markers association extraction pattern
set. This collection of patterns was used for the pattern-based relation
extraction of chemical entity **\[SUBSTANCE\]** associations to markers **\[MARKER\]**

	Available fields are:
	1. "marker_pattern_id":    "LIMTOX marker relation pattern identifier"
	2. "marker_pattern":       "LIMTOX marker relation pattern string"
	3. "marker_pattern_norm":  "LIMTOX marker relation pattern string normalized"
	                           "version (GENIA tagger stemming)"
	4. "pattern_length":       "Pattern token length"
	5. "pattern_type":         "Describe pattern types as 'Increase', 'Decrease',"
	                           "'Uncertain' or 'No Effect'"
	6. "pattern_trigger_term": "Pattern trigger term"

## LimTox P450 Cytochromes Induction Pattern extraction: [limtox_p450_cyps_induction_pattern.json](./limtox_p450_cyps_induction_pattern.json.gz)

This dictionary contains the LimTox P450 Cytochromes \(CYPs\) induction
association extraction pattern set. This collection of patterns was used for
the pattern-based induction relation extraction of chemical entity
**\[SUBSTANCE\]** associations to P450 CYPs **\[P450_CYPS\]**

	Available fields are:
	1. "cyp_induction_pattern_id":   "LIMTOX induction relation pattern identifier"
	2. "cyp_induction_pattern":      "LIMTOX induction relation pattern string"
	3. "cyp_induction_pattern_norm": "LIMTOX induction relation pattern string"
	                                 "normalized version (GENIA tagger stemming)"
	4. "pattern_length":             "Pattern token length"

## LimTox P450 Cytochromes Inhibition Pattern extraction: [limtox_p450_cyps_inhibition_pattern.json](./limtox_p450_cyps_inhibition_pattern.json.gz)

This dictionary contains the LimTox P450 Cytochromes \(CYPs\) inhibition
association extraction pattern set. This collection of patterns was used for
the pattern-based inhibition relation extraction of chemical entity
**\[SUBSTANCE\]** associations to P450 CYPs **\[P450_CYPS\]**

	Available fields are:
	1. "cyp_inhibition_pattern_id":  "LIMTOX inhibition relation pattern identifier"
	2. "cyp_inhibition_pattern":      "LIMTOX inhibition relation pattern string"
	3. "cyp_inhibition_pattern_norm": "LIMTOX inhibition relation pattern string"
	                                  "normalized version (GENIA tagger stemming)"
	4. "pattern_length":              "Pattern token length"
