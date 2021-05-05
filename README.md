# WP_IMPORT
Keep the updated json in theme/wpimp-data/data.json

Features:

Imports the events from the JSON file.
Can be triggered via Wordpress CLI: event name is 'wpimp_cron_hook'
Update event will on multiple import.
After the import, please send an automated email to logging@agentur-loop.com

Events list : {baseURL}/event/
Note: In events list the events status (Past, Today remaining days will be shown)

Can be export via {baseURL}/wp-json/wp/v2/event?per_page=100

Plugin dependency:

ACF
ACF export is  theme/wpimp-data/

