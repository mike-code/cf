#!/bin/zsh

echo "🍻 Terminate Mutagen"
mutagen daemon start
while ! [ $(mutagen list 2>&1 | grep "unable to connect to daemon" | wc -l) = 0 ]; do
    sleep 1
done
mutagen project terminate
echo "OK"

echo "🍻 Run Docker"
docker-compose -f docker-compose.local.yml down --remove-orphans
docker-compose -f docker-compose.local.yml up -d

echo "🍻 Run Mutagen"
mutagen project start

echo "🍻 Waiting for files to sync"
while ! [ $(mutagen list | grep "Watching for changes" | wc -l) = 3 ]; do
    sleep 1
done
echo "OK"

docker-compose -f docker-compose.local.yml exec phpfpm /bin/sh -c "kill -USR2 1"

echo "Done"
