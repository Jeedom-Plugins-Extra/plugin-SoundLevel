#!/bin/sh
while true; do
    arecord -q -D $hw -f cd -d $duration -t raw $folder/noise.wav
    amplitude=$(lame -r $folder/noise.wav 2>&1 | sed -n '/+/,/db/p' | sed 's/\ReplayGain: +//' | sed 's/\dB//' | sed -n 1p)
    amplitude=$(echo "scale=2; $amplitude * -1" | bc -l)
    echo $amplitude
done
