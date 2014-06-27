#!/usr/bin/python
# -*- coding: utf-8 -*-
import sys
import os
import logging
logging.basicConfig(level=logging.INFO)
import psycopg2
from rdkit import Chem
from rdkit.Chem import Draw
#logging.getLogger('suds.client').setLevel(logging.DEBUG) #Enabling specific module logging mode of suds to debug

#Script that gets 3 parameters:
    # 1.- String with the SMILES of a compound
    # 2.- The path with where the image will be saved in
    # 3.- The image format used to generate the image file

#And generates a image file of the molecule (retrieving 0 if no error)


def main():

    #First we get the parameters
    """if len(sys.argv) != 4:
        return 1
    smile=sys.argv[1]
    path=sys.argv[2]
    image_format=sys.argv[3]

    """

    print "hola"
    sys.exit()




    #We setup the image file
    size = (240, 240)
    #Create the molecule using SMILES as input
    m = Chem.MolFromSmiles(smile)

    #Draw the molecule
    Draw.MolToImage(m, path, size)

    return 0
    sys.exit()

main()