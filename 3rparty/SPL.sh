#!/bin/sh
while true; do
    arecord -q -D $1 -f cd -d $2 -t raw $3/noise.wav
    amplitude=$(lame -r $folder/noise.wav 2>&1 | sed -n '/+/,/db/p' | sed 's/\ReplayGain: +//' | sed 's/\dB//' | sed -n 1p)
    amplitude=$(echo "scale=2; $amplitude * -1" | bc -l)
    echo $amplitude
done
