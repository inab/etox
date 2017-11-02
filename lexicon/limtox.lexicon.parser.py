import json
import pandas
import numpy as np

#1 Marker entity identifier (unspecific term, compound Id or UniProt Accession number)
#2 Marker entity database namespace/class
#3 Marker entity name type: 1: corresponds to marker name, 0=corresponds to stop names of non-marker names whose abbreviations/acronyms resemble marker symbols (these were used to disambiguate marker from non marker symbols)
#4 Marker entity name string
#5 Concept namespace (liver_marker)
#6 Marker species normalization (9606=human, compound=species independent)

header = (
  "marker_identifier",
  "marker_namespace",
  "marker_type_name",
  "marker_full_name",
  "concept_namespace",
  "marker_normalization",
)

infile = ("liver_marker_dict.tsv")
df = pandas.read_csv(infile, sep = '\t', names = header, encoding = 'latin-1', \
  na_values = ['NA'])
df.drop_duplicates(keep = "first")

dict_name = ("liver_marker")
output = { dict_name: df.to_dict(orient = "records") }

outfile = open(("%s.json") % (dict_name), 'w')
outfile.write(json.dumps(output, indent = 2))
outfile.close()

#01 Chemical entity name      
#02 ChemIDplus identifier
#03 ChEBI identifier
#04 CAS registry number 
#05 PubChem compound identifier
#06 PubChem substance identifier
#07 IUPAC International Chemical Identifier (InChI)
#08 DrugBank identifier
#09 Human Metabolome database identifier
#10 KEGG compound  identifier
#11 KEGG drug  identifier
#12 MeSH substance    identifier
#13 Number of different databases to which the chemical entity name can be linked
#14 SMILES (simplified molecular-input line-entry system) string
#15 Integer reflecting whether a name to structure conversion could be succesfully done (1=yes, 0=no)

header = (
  "Chemical_name",
  "ChemIDplus_id",
  "ChEBI_id",
  "CAS_registry",
  "PubChem_compound_id",
  "PubChem_substance_id",
  "IUPAC_International_Chemical_id",
  "Drugback_id",
  "Human_metabolome_id",
  "KEGG_compound_id",
  "KEGG_drug_id",
  "MeSH_substance_id",
  "numb_links_to_external_dbs",
  "SMILES",
  "convertable_to_structure",
)

def cast_structure(x):
  return "Y" if int(x) > 0 else "N"

input_dtype = {"PubChem_compound_id": str, "PubChem_substance_id": str}

infile = ("chemicals_dict.tsv")
df = pandas.read_csv(infile, sep = '\t', names = header, encoding = 'latin-1', \
  converters = {"convertable_to_structure": cast_structure}, na_values = ['NA'],
  dtype = input_dtype)

df.drop_duplicates(keep = "first")

dict_name = ("chemical_entity")
output = { dict_name: df.to_dict(orient = "records") }

outfile = open(("%s.json") % (dict_name), 'w')
outfile.write(json.dumps(output, indent = 2))
outfile.close()

#01 Chemical entity concept name
#02 Chemical entity database identifier (or 0 in case no database identifier was provided by the MeSH database)
#03 MeSH unique identifier (UI) of the chemical entity

header = (
  "Chemical_concept_name",
  "Chemical_db_id",
  "MeSH",
)

def cast_db_id(x):
  return "NA" if str(x) == "0" else x

infile = ("chemicals_mesh.tsv")
df = pandas.read_csv(infile, sep = '\t', names = header, encoding = 'latin-1', \
  na_values = ['NA'], converters = {"Chemical_db_id": cast_db_id})
df.drop_duplicates(keep = "first")

dict_name = ("chemical_mesh")
output = { dict_name: df.to_dict(orient = "records") }

outfile = open(("%s.json") % (dict_name), 'w')
outfile.write(json.dumps(output, indent = 2))
outfile.close()

#01 CYPs canonical name symbol
#02 CYPs canonical root form/stem
#03 CYPs family identifier
#04 CYPs  subfamily letters
#05 CYPs  protein identifier

header = (
  "cytochrome_canonical_symbol",
  "cytochrome_canonical_root",
  "cytocrome_family_id",
  "cytocrome_subfamily_id",
  "cytocrome_protein_id",
)

infile = ("cyps_canonical_naming.tsv")
df = pandas.read_csv(infile, sep = '\t', names = header, encoding = 'latin-1', \
  na_values = ['NA'])
df.drop_duplicates(keep = "first")

dict_name = ("p450_cytochrome")
output = { dict_name: df.to_dict(orient = "records") }

outfile = open(("%s.json") % (dict_name), 'w')
outfile.write(json.dumps(output, indent = 2))
outfile.close()

#01 Term mapping possible: NO= No direct concept grounding possible, YES= concept grounding possible
#02 Hepatoxicity, DILI or adverse liver effect term/phrase (original)
#03 Hepatoxicity, DILI or adverse liver effect term/phrase (stemmed, lower case version)
#04 Hepatoxicity, DILI or adverse liver effect term/phrase part of speech (POS) tagging
#05 EFPIA concept identifier mapping
#06 COSTART concept hit
#07 MedDRA concept identifier mapping
#08 MPheno concept identifier mapping
#09 Ontology of Adverse Events (OAE) concept identifier mapping
#10 Disease Ontology concept identifier mapping (DOID)
#11 Gemina symptom concept identifier mapping
#12 Human-phenotype (HP) concept identifier mapping
#13 Mouse Pathology Ontology concept identifier mapping
#14 MESH_OMIM concept identifier mapping
#15 PolySearch concept identifier mapping
#16 eTOX ontology concept identifier mapping

header = (
  "mapped",
  "original_entry",
  "stemmed_entry",
  "speech_entry",
  "EFPIA_mapping_id",
  "COSTART_concept",
  "MedDRA_mapping_id",
  "MPheno_mapping_id",
  "adverse_events_mapping_id",
  "disease_ontology_mapping_id",
  "gemina_sympton_mapping_id",
  "human-phenotype_mapping_id",
  "mouse_pathology_mapping_id",
  "mesh_omim_mapping_id",
  "polysearch_mapping_id",
  "etox_mapping_id",
)

def cast_mapping(x):
  return x.lower()

infile = ("hepatotoxicity_dict.tsv")
df = pandas.read_csv(infile, sep = '\t', names = header, encoding = 'latin-1', \
  converters = {"mapped": cast_mapping}, na_values = ['NA'])

df.drop_duplicates(keep = "first")
df = df.replace("-", "NA")

dict_name = ("hepatotoxicity")
output = { dict_name: df.to_dict(orient = "records") }

outfile = open(("%s.json") % (dict_name), 'w')
outfile.write(json.dumps(output, indent = 2))
outfile.close()

#01 LIMTOX substrate/product relation pattern identifier
#02 LIMTOX substrate/product relation pattern string
#03 LIMTOX substrate/product relation pattern string normalized version (GENIA tagger stemming)
#04 Pattern token length

header = (
  "substrate_pattern_id",
  "substrate_pattern",
  "substrate_pattern_norm",
  "pattern_length",
)                                

infile = ("LimTox_cyps_substrate_pattern.tsv")
df = pandas.read_csv(infile, sep = '\t', names = header, encoding = 'latin-1', \
  na_values = ['NA'])

df.drop_duplicates(keep = "first")

dict_name = ("limtox_cyps_pattern")
output = { dict_name: df.to_dict(orient = "records") }

outfile = open(("%s.json") % (dict_name), 'w')
outfile.write(json.dumps(output, indent = 2))
outfile.close()

#01 LIMTOX adverse event pattern identifier
#02 LIMTOX adverse event pattern string
#03 LIMTOX adverse event pattern string normalized version (GENIA tagger stemming)
#04 Pattern token length

header = (
  "adverse_pattern_id",
  "adverse_pattern",
  "adverse_pattern_norm",
  "pattern_length",
)                                

infile = ("LimTox_adverse_pattern.tsv")
df = pandas.read_csv(infile, sep = '\t', names = header, encoding = 'latin-1', \
  na_values = ['NA'])

df.drop_duplicates(keep = "first")

dict_name = ("limtox_adverse_pattern")
output = { dict_name: df.to_dict(orient = "records") }

outfile = open(("%s.json") % (dict_name), 'w')
outfile.write(json.dumps(output, indent = 2))
outfile.close()

#01 LIMTOX substance location relation pattern identifier
#02 LIMTOX substance location relation pattern string
#03 LIMTOX substance location relation pattern string normalized version (GENIA tagger stemming)
#04 Pattern token length

header = (
  "location_pattern_id",
  "location_pattern",
  "location_pattern_norm",
  "pattern_length",
)                                

infile = ("LimTox_location_pattern.tsv")
df = pandas.read_csv(infile, sep = '\t', names = header, encoding = 'latin-1', \
  na_values = ['NA'])

df.drop_duplicates(keep = "first")

dict_name = ("limtox_location_pattern")
output = { dict_name: df.to_dict(orient = "records") }

outfile = open(("%s.json") % (dict_name), 'w')
outfile.write(json.dumps(output, indent = 2))
outfile.close()

#01 LIMTOX marker relation pattern identifier
#02 LIMTOX marker relation pattern string
#03 LIMTOX marker relation pattern string normalized version (GENIA tagger stemming)
#04 Pattern token length
#05 Pattern type (I=Increase, D=descrease, U= Uncertain, N=no effect)
#06 Pattern trigger term

header = (
  "marker_pattern_id",
  "marker_pattern",
  "marker_pattern_norm",
  "pattern_length",
  "pattern_type",
  "pattern_trigger_term",
)                                

def cast_type(x):
  return "Increase" if x == "I" else "Decrease" if x == "D" else "Uncertain" \
    if x == "U" else "No Effect" if x == "N" else "NA"

infile = ("LimTox_marker_pattern.tsv")
df = pandas.read_csv(infile, sep = '\t', names = header, encoding = 'latin-1', \
  na_values = ['NA'], converters = {"pattern_type": cast_type})

df.drop_duplicates(keep = "first")

dict_name = ("limtox_marker_pattern")
output = { dict_name: df.to_dict(orient = "records") }

outfile = open(("%s.json") % (dict_name), 'w')
outfile.write(json.dumps(output, indent = 2))
outfile.close()

#01 LIMTOX induction relation pattern identifier
#02 LIMTOX induction relation pattern string
#03 LIMTOX induction relation pattern string normalized version (GENIA tagger stemming)
#04 Pattern token length

header = (
  "cyp_induction_pattern_id",
  "cyp_induction_pattern",
  "cyp_induction_pattern_norm",
  "pattern_length",
)                                

infile = ("LimTox_cyps_induction_pattern.tsv")
df = pandas.read_csv(infile, sep = '\t', names = header, encoding = 'latin-1', \
  na_values = ['NA'])

df.drop_duplicates(keep = "first")

dict_name = ("limtox_p450_cyps_induction_pattern")
output = { dict_name: df.to_dict(orient = "records") }

outfile = open(("%s.json") % (dict_name), 'w')
outfile.write(json.dumps(output, indent = 2))
outfile.close()

#01 LIMTOX inhibition relation pattern identifier
#02 LIMTOX inhibition relation pattern string
#03 LIMTOX inhibition relation pattern string normalized version (GENIA tagger stemming)
#04 Pattern token length

header = (
  "cyp_inhibition_pattern_id",
  "cyp_inhibition_pattern",
  "cyp_inhibition_pattern_norm",
  "pattern_length",
)                                

infile = ("LimTox_cyps_inhibition_pattern.tsv")
df = pandas.read_csv(infile, sep = '\t', names = header, encoding = 'latin-1', \
  na_values = ['NA'])

df.drop_duplicates(keep = "first")

dict_name = ("limtox_p450_cyps_inhibition_pattern")
output = { dict_name: df.to_dict(orient = "records") }

outfile = open(("%s.json") % (dict_name), 'w')
outfile.write(json.dumps(output, indent = 2))
outfile.close()
--
