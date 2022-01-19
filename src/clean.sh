#!/usr/bin/bash
#set this up in a crontab and set it to run after every school day to archive the logs and clean students from the departed folder
mv -v departed/* registered_phid/
cat 'p' > departed/.placeholder
name=$(date '+%Y-%m-%d')
mv log/inout.log log/$name.log.old