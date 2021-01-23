#!/bin/zsh
# Normal mode prints
basePath="/Applications/XAMPP/xamppfiles/htdocs/Drueckler3DDrucke/Prusa_Slicer"
DIR_BASENAME="$basePath/output"
printerSettings="$basePath/printers/Ender3Pro.ini"
printSettings="settings/012mm100pct10dg.ini"

cd $basePath;

find "./uploads/temp" -iname "*.stl" | while read MODEL


do 
    for NOZZLE in nozzles/*.ini; do 
        DIR_NOZZLE="$(basename -s .ini $NOZZLE)"
        for FILAMENT in filaments/PLA.ini; do 
            DIR_FILAMENT="$(basename -s .ini $FILAMENT)"
            for SETTINGS in $printSettings ; do 
                DIR_PATH="${DIR_BASENAME}/${DIR_FILAMENT}/${DIR_NOZZLE}/"
				echo "$DIR_PATH"
                mkdir -p "${DIR_PATH}"
                ./runScript.sh \
				-g \
	            --load "$printerSettings" \
	            --load "$NOZZLE" \
	            --load "$FILAMENT" \
	            --load "$SETTINGS" \
				--output "$DIR_PATH" \
				"$MODEL" 
				
				
                
                #--post-process scripts/prusaslicer_massage.py \
				#--output "${DIR_PATH}" "${MODEL}"

            done
        done
    done
done
