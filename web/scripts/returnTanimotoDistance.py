#!/usr/bin/python
# -*- coding: utf-8 -*-
import sys
import os
import re
import json
from rdkit import Chem
from rdkit import DataStructs
from rdkit.Chem.Fingerprints import FingerprintMols

def main():
    #First we get the input parameters
    existMol1=False
    existMol2=False
    inchi1=sys.argv[1].strip()
    inchi2=sys.argv[2].strip()
    smile1=sys.argv[3].strip()
    smile2=sys.argv[4].strip()
    #message="Dentro del script returnTanimotoDistance.py"
    mol1=Chem.MolFromSmiles(smile1)
    if mol1==None:
        #If smile1 returns no mol(None), we try with inchi1. One of both should exist because of the previous restrictions
        mol1=Chem.MolFromInchi(inchi1)

    mol2=Chem.MolFromSmiles(smile2)
    if mol2==None:
        #If smile12 returns no mol(None), we try with inchi2. One of both should exist because of the previous restrictions
        mol2=Chem.MolFromInchi(inchi2)

    ms = [mol1, mol2]
    fps = [FingerprintMols.FingerprintMol(x) for x in ms]
    tanimotoCoeff=DataStructs.FingerprintSimilarity(fps[0],fps[1])
    print("%.3f" % tanimotoCoeff)
main()

""""
>>> ms = [Chem.MolFromSmiles('CCOC'), Chem.MolFromSmiles('CCO'),
... Chem.MolFromSmiles('COC')]
>>> fps = [FingerprintMols.FingerprintMol(x) for x in ms]
>>> DataStructs.FingerprintSimilarity(fps[0],fps[1])
0.6...
>>> DataStructs.FingerprintSimilarity(fps[0],fps[2])
0.4...
>>> DataStructs.FingerprintSimilarity(fps[1],fps[2])
0.25
"""