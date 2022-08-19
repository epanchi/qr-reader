#!/bin/bash
## directory image iterator script

FOLDER=$1
FILEPATH=$2
DOCUMENTID=$3

pdftocairo $FILEPATH -png $FOLDER'/'$DOCUMENTID

for file in $(find ${FOLDER}   -name '*.jpg' -or -name '*.png' -or -name '*.jpeg'  );
do
    ## Store QRcode on result.txt file
    ## this file will be processed on document 
    zbarimg $file >> $FOLDER'/'result.txt
    

done;