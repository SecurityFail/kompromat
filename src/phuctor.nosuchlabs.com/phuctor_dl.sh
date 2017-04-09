#!/bin/sh

for a in dupes phuctored sadmods; do
    echo $a
    cd $a
    curl -m 86400 --connect-timeout 600 "http://phuctor.nosuchlabs.com/$a" | grep -Po '/gpgkey/.*?(?=")'| cut -d/ -f3 | xargs -i echo http://phuctor.nosuchlabs.com/download/{} | xargs --max-args=128 --max-procs=8 wget -qc --show-progress --progress=bar
    curl -m 86400 --connect-timeout 600 "http://siphnos.mkj.lt/phuctor-stats/$a.html" | grep -Po '/gpgkey/.*?(?=")'| cut -d/ -f3 | xargs -i echo http://phuctor.nosuchlabs.com/download/{} | xargs --max-args=128 --max-procs=8 wget -qc --show-progress --progress=bar
    cd ..
done
