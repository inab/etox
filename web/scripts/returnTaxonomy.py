#!/usr/bin/python
# -*- coding: utf-8 -*-
import sys
import os
import re
import json
import cgi
from os import environ
import cgitb
cgitb.enable()

sys.stderr = sys.stdout
from Bio import Entrez


ret_number=100
tmpString=""



Entrez.email = "acanada@cnio.es"
if not Entrez.email:
    print "you must add your email address"
    sys.exit(2)

def get_tax_id(species):
    """
    	to get data from ncbi taxomomy, we need to have the taxid. we can
		get that by passing the species name to esearch, which will return
		the tax id
	"""
    species = species.replace(" ", "+").strip()
    search = Entrez.esearch(term = species, db = "taxonomy", retmode = "xml",RetMax=ret_number)
    record = Entrez.read(search)
    listaIdTaxonomy=record['IdList'] #En listaIdTaxonomy tenemos el listado de Taxonomy de la busqueda.
    #print record[]
    return listaIdTaxonomy

def get_scientifc_name_from_tax_id(taxid,selectNumber):
    """once we have the taxid, we can fetch the record"""
    search = Entrez.efetch(id = taxid, db = "taxonomy", retmode = "xml")
    record=Entrez.read(search)
    try:
    	scientificName=record[0]["ScientificName"]
    except:
    	pass
    	sys.exit()
    return scientificName

###############################################################################################
###############################################################################################
###############################################################################################
################################### START OF THE APPLICATION ##################################
###############################################################################################
###############################################################################################
###############################################################################################
def main():
    #try:
    #    organismName=sys.argv[1]
    #except:
    #    emptyArray=[]
    #    #We return the json encoded emptyArray

    try:
        fs = cgi.FieldStorage()
        organismName=fs['textminingName'].value
    except:
        emptyArray=[]
        #We return the json encoded emptyArray


    listaIdTaxonomy=get_tax_id(organismName)
    arrayJson=json.dumps(listaIdTaxonomy)
    print "Content-Type: application/json\n"
    print arrayJson
    sys.exit()

main()