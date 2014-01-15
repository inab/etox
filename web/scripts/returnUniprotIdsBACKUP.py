#!/usr/bin/python
# -*- coding: utf-8 -*-
import sys
import os
import re
import MySQLdb
import cgi
import urllib
import cgitb; cgitb.enable();
sys.stderr = sys.stdout
from Bio import Entrez
Entrez.email = "acanada@cnio.es"
tmpString = ""
ret_number=100
#SUDS for SOAP web services stuff
import logging
#logging.basicConfig(level=logging.INFO)
#logging.getLogger('suds.client').setLevel(logging.DEBUG) #Enabling specific module logging mode of suds to debug

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

def get_scientifc_name_from_tax_id(taxid):
    """once we have the taxid, we can fetch the record"""
    search = Entrez.efetch(id = taxid, db = "taxonomy", retmode = "xml")
    record=Entrez.read(search)
    #print record
    try:
    	scientificName=record[0]["ScientificName"]
    except:
    	tmpString="Organism:<input id=\"textminingOrganismName\" type=\"text\" NAME=\"textminingOrganismName\" maxlenght=\"255\" size=\"20\" value=\""+organismName+"\" onChange=\"insertTaxonomy();\">(<a href=\"javascript:;\" onClick=\"insertTaxonomy();\">Click to search</a>)It has been a problem searching in NCBI Taxonomy. Please try again\n"
    	print tmpString
    	sys.exit()
    #sys.exit()
    return scientificName


#Creamos  un cliente para el servicio a partir del WSDL
from suds.client import Client

print "Content-Type: text/html\n"

url = 'http://www.ncbi.nlm.nih.gov/entrez/eutils/soap/v2.0/efetch_taxon.wsdl'
client = Client(url)
#print client

#############################################################################
#result=client.service.getLiteEntity('biphenyl-2,3-diol','CHEBI ID',200,'ALL')
#############################################################################
#client.service.getCompleteEntity('16205');


#Script que recibe un textMiningOrganismName y devuelve una serie de opciones con el siguiente formato

fs = cgi.FieldStorage()
enzymeName=fs['enzymeName'].value
selectNumber=fs['selectNumber'].value
typeSearch=fs['typeSearch'].value

if typeSearch=="selected":
	taxid=fs['taxid'].value
	query="http://www.uniprot.org/uniprot/?query="+str(enzymeName)+" AND taxonomy%3a"+taxid+"&format=tab&columns=id,entry name,reviewed,protein names,genes,organism,length"
	query=query.replace(" ","+")
	#print "<br/>"+str(query)+"<br/>"
	
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
		tmpString+= "Sorry but no protein was found for that enzyme. Repeat the search.<br/>"
		tmpString+="<select id=\"listOfProteins_"+str(selectNumber)+"\" name=\"listOfProteins_"+str(selectNumber)+"\" size=\"5\" multiple=\"multiple\">\n"
		tmpString+="<OPTION VALUE=\"\">\n"
		tmpString+="</select>\n"
		print tmpString
		sys.exit()
	else:
		tmpString+="<div class=\"linksToCompounds\">"
		for proteina in diccionarioProteinas:
			tmpString+="<a href=\"http://www.uniprot.org/uniprot/"+str(proteina)+"\" target=\"_blank\">"+str(proteina)+"</a>, "
		tmpString+="</div>"
		tmpString+="<select id=\"listOfProteins_"+str(selectNumber)+"\" name=\"listOfProteins_"+str(selectNumber)+"\" size=\"5\" multiple=\"multiple\">\n"
		for proteina in diccionarioProteinas:
			tmpString+="<OPTION VALUE=\""+str(proteina)+"\">("+proteina+")-> "+str(diccionarioProteinas[proteina])+"\n"
		tmpString+="</select>\n"
		print tmpString
elif typeSearch=="conventioned":
	stringOrganisms=fs['listOrganisms'].value
	arrayOrganisms=stringOrganisms.split("_")
	arrayOrganisms.sort()
	diccionarioProteinas={}
	organismsCounter=0
	for organism in arrayOrganisms:
		#print "<br/>"+str(organism)
		listTaxIds=get_tax_id(organism)
		#print "<br/>"+str(listTaxIds)
		for taxid in listTaxIds:
			query="http://www.uniprot.org/uniprot/?query="+str(enzymeName)+" AND taxonomy%3a"+taxid+"&format=tab&columns=id,entry name,reviewed,protein names,genes,organism,length"
			#print "<br/>"+query
			query=query.replace(" ","+")		
			filehandle = urllib.urlopen(query)
			lineCounter=0
			for line in filehandle.readlines():
				if lineCounter==0:
					pass
				else:
					arrayFields=line.split("\t")
					entry=arrayFields[0]
					proteinName=arrayFields[3]
					#Tenemos que añadir a la clave un indice ficticio que habrá que borrar más adelante para que las proteínas repetidas entre varios organismos se guarden como entradas diferentes y no se machaquen
					diccionarioProteinas[str(organismsCounter)+"_"+str(entry)]="["+str(organism)+"] "+str(proteinName)
				lineCounter+=1
			filehandle.close()
		organismsCounter+=1	
	#print "<br/>"+str(diccionarioProteinas)
	#sys.exit()
	#primero miramos a ver si hay algo en el array, sino devolvemos el error
	if len(diccionarioProteinas)==0:
		tmpString+= "Sorry but no protein was found for that enzyme. Repeat the search<br/>"
		tmpString+="<select id=\"listOfProteins_"+str(selectNumber)+"\" name=\"listOfProteins_"+str(selectNumber)+"\" size=\"5\" multiple=\"multiple\">\n"
		tmpString+="<OPTION VALUE=\"\">\n"
		tmpString+="</select>\n"
		print tmpString
		sys.exit()
	else:
		tmpString+="<div class=\"linksToCompounds\">"
		for proteina in diccionarioProteinas:
			proteinaSinIndiceParaValue=proteina[2:]
			tmpString+="<a href=\"http://www.uniprot.org/uniprot/"+str(proteinaSinIndiceParaValue)+"\" target=\"_blank\">"+str(proteinaSinIndiceParaValue)+"</a>, "
		tmpString+="</div>"
		tmpString+="<select id=\"listOfProteins_"+str(selectNumber)+"\" name=\"listOfProteins_"+str(selectNumber)+"\" size=\"5\" multiple=\"multiple\">\n"
		for proteina in diccionarioProteinas:
			proteinaSinIndiceParaValue=proteina[2:]
			tmpString+="<OPTION VALUE=\""+str(proteinaSinIndiceParaValue)+"\">"+proteinaSinIndiceParaValue+"  "+str(diccionarioProteinas[proteina])+"\n"
		tmpString+="</select>\n"
		print tmpString
elif typeSearch=="all":
	query="http://www.uniprot.org/uniprot/?query="+str(enzymeName)+" &format=tab&columns=id,entry name,reviewed,protein names,genes,organism,length"
	#print "<br/>"+query
	query=query.replace(" ","+")		
	filehandle = urllib.urlopen(query)
	lineCounter=0
	diccionarioSpeciesProteinas={}
	for line in filehandle.readlines():
		if lineCounter==0:
			pass
		else:
			arrayFields=line.split("\t")
			entry=arrayFields[0]
			proteinName=arrayFields[3]
			specie=arrayFields[5]
			#Generamos las entradas del diccionario que en este caso se ordenan según organismo. Para ello:
			#Primero buscamos si existe una entrada para ese organismo:
			if specie in diccionarioSpeciesProteinas:
				#Ya existe la entrada para esa specie. Guardamos una entrada para la proteína en esa especie
				diccionarioProteinas=diccionarioSpeciesProteinas[specie]
				diccionarioProteinas[str(entry)]=str(proteinName)
			else:
				#Creamos una entrada nueva para esa specie
				diccionarioTemporal={}
				diccionarioTemporal[str(entry)]=str(proteinName)
				diccionarioSpeciesProteinas[specie]=diccionarioTemporal
		lineCounter+=1
	filehandle.close()
	#primero miramos a ver si hay algo en el array, sino devolvemos el error
	#print diccionarioSpeciesProteinas
	#Buscamos en las claves para ordenar por orden alfabético:
	
	clavesSpecies=diccionarioSpeciesProteinas.keys()
	clavesSpecies.sort()
	#print clavesSpecies
	if len(diccionarioSpeciesProteinas)==0:
		tmpString+= "Sorry but no protein was found for that enzyme. Repeat the search<br/>"
		tmpString+="<select id=\"listOfProteins_"+str(selectNumber)+"\" name=\"listOfProteins_"+str(selectNumber)+"\" size=\"5\" multiple=\"multiple\">\n"
		tmpString+="<OPTION VALUE=\"\">\n"
		tmpString+="</select>\n"
		print tmpString
		sys.exit()
	else:
		tmpString+="<div class=\"linksToCompounds\">"
		for specie in clavesSpecies:
			tmpString+="<br/><small>"+str(specie)+":"
			diccionarioProteinas=diccionarioSpeciesProteinas[specie]
			for proteina in diccionarioProteinas:
				tmpString+="<a href=\"http://www.uniprot.org/uniprot/"+str(proteina)+"\" target=\"_blank\">"+str(proteina)+"</a>, "
			tmpString+="</small>"
		tmpString+="</div>"
		tmpString+="<select id=\"listOfProteins_"+str(selectNumber)+"\" name=\"listOfProteins_"+str(selectNumber)+"\" size=\"5\" multiple=\"multiple\">\n"
		for specie in clavesSpecies:
			diccionarioProteinas=diccionarioSpeciesProteinas[specie]
			for proteina in diccionarioProteinas:
				tmpString+="<OPTION VALUE=\""+str(proteina)+"\">("+proteina+")-> "+str(diccionarioProteinas[proteina])+"\n"
		tmpString+="</select>\n"
		print tmpString