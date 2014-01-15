#!/usr/bin/python
# -*- coding: utf-8 -*-
import sys
import os
import re
import cgi
import urllib
import cgitb; cgitb.enable();
sys.stderr = sys.stdout
import json
import operator

def main():

    fs = cgi.FieldStorage()
    enzymeName=fs['enzymeName'].value
    taxId=fs['taxId'].value
    query="http://www.uniprot.org/uniprot/?query="+str(enzymeName)+" AND taxonomy%3a"+taxId+"&format=tab&columns=id,entry name,reviewed,protein names,genes,organism,length"
    query=query.replace(" ","+")
    filehandle = urllib.urlopen(query)
    lineCounter=0
    diccionarioProteinas={}
    for line in filehandle.readlines():
    	if lineCounter==0:
    		pass
    	else:
    		arrayFields=line.split("\t")
    		entry=arrayFields[0]
    		proteinName=arrayFields[3]
    		diccionarioProteinas[entry]=proteinName
    	lineCounter+=1
    filehandle.close()
    #primero miramos a ver si hay algo en el array, sino devolvemos el error
    if len(diccionarioProteinas)==0:
        emptyArray=[]
        #We return the json encoded emptyArray
        arrayJson=json.dumps(emptyArray)
        print "Content-Type: application/json\n"
        print arrayJson
        sys.exit()
    else:

        proteinDictSorted = sorted(diccionarioProteinas.iteritems(), key=operator.itemgetter(1))
        arrayJson=json.dumps(proteinDictSorted)
        print "Content-Type: application/json\n"
        print arrayJson
        sys.exit()

main()