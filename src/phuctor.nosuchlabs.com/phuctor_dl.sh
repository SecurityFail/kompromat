#!/bin/sh

for a in dupes phuctored sadmods; do
    echo $a
    cd $a
    curl "http://phuctor.nosuchlabs.com/$a" | grep -Po '/gpgkey/.*?(?=")'| cut -d/ -f3 | xargs -i echo http://phuctor.nosuchlabs.com/download/{} | xargs --max-args=128 --max-procs=8 wget -qc --show-progress --progress=bar
    cd ..
done
