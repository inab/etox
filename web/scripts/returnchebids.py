#!/usr/bin/python
# -*- coding: utf-8 -*-
import sys
import os
import json
import cgi
from os import environ
import cgitb
cgitb.enable()
#SUDS for SOAP web services stuff
import logging
from suds.client import Client
logging.basicConfig(level=logging.INFO)
#logging.getLogger('suds.client').setLevel(logging.DEBUG) #Enabling specific module logging mode of suds to debug

#Script que recibe el nombre de un organismo y devuelve un json con la siguiente estructura:
#{"CHEBI:491858": "1,4-dihydroxynaphthalene bis(beta-D-xylopyranoside)", "CHEBI:34063": "naphthalene-1,4-diol"}




def main():


    #Creamos  un cliente para el servicio a partir del WSDL
    url = 'http://www.ebi.ac.uk/webservices/chebi/2.0/webservice?wsdl'
    client = Client(url)

    try:
        fs = cgi.FieldStorage()
        chebiName=fs['chebiName'].value
    except:
        emptyArray=[]
        #We return the json encoded emptyArray
        arrayJson=json.dumps(emptyArray)
        print "Content-Type: application/json\n"
        print arrayJson
        sys.exit()

    arrayChebiIds={}

    #############################################################################
    entities=client.service.getLiteEntity(chebiName,'chebiId',2,'ALL')
    #############################################################################
    try:
    	listElements=entities[0]
    except:
    	sys.exit()
    for liteEntity in listElements:
        chebiId=liteEntity["chebiId"]
        #Tenemos el chebiId y podemos llamar al servicio getCompleteEntity(str(chebiId)). Para ello hacemos:
        completeEntity=client.service.getCompleteEntity(str(chebiId))
        nombreCompuesto=str(completeEntity[1])
        arrayChebiIds[chebiId]=nombreCompuesto

    #Generamos un json para poder devolver a php
    arrayJson=json.dumps(arrayChebiIds)
    print "Content-Type: application/json\n"
    print arrayJson
    sys.exit()

main()