# Readme
Currently the data file has been placed in the theme/wpimp-data/data.json.

Features:
=====================================

Imports the events from the JSON file.

Can be triggered via Wordpress CLI: event name is 'wpimp_cron_hook'

Event will update on multiple import with same ID(ID from data.json).
After the import, an email will be sent to logging@********.com

Events list : {baseURL}/event/
Note: In events list the events status (Past, Today or  remaining days will be shown)

Can be export via {baseURL}/wp-json/wp/v2/event?per_page=100

Plugin dependency:
==========================================
ACF
ACF export is  theme/wpimp-data/

