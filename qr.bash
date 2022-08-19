#!/bin/bash
## directory image iterator script

FOLDER=$1

for file in $(find ${FOLDER}   -name '*.jpg' -or -name '*.png' -or -name '*.jpeg'  );
do
    ## Store QRcode on result.txt file
    ## this file will be processed on document 
    zbarimg $file >> $FOLDER'/'result.txt
    

done;