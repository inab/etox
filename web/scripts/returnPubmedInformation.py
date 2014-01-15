#!/usr/bin/python
# -*- coding: utf-8 -*-
import sys
import os
import json
import urllib
from types import ListType
from Bio import Entrez
from Bio import SwissProt
from Bio import ExPASy

Entrez.email = "acanada@cnio.es"
if not Entrez.email:
    print "you must add your email address"
    sys.exit(2)

#Script que recibe un PubmedId y devuelve un json con la siguiente estructura:

def get_title(pubmedId):
    #once we have the taxied, we can fetch the record
    arrayPubmeds={}
    search = Entrez.efetch(id = pubmedId, db = "pubmed", retmode = "xml")
    record=Entrez.read(search)
    articleTitle=record[0]['MedlineCitation']['Article']['ArticleTitle']
    arrayPubmeds[pubmedId]=articleTitle
    return arrayPubmeds



pubmedId=sys.argv[1]
arrayPubmeds=get_title(pubmedId)
arrayJson=json.dumps(arrayPubmeds)
print arrayJson
sys.exit()