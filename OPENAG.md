Using Open AG
=============

Format
------

    openag [action] [docker] [..extras...]

Start, stop, restart, destroy, status, update
---------------------------------------------

Each of these commands take can be run with out additional parameters, in whuch case they run against all the dockers.  Optionally one or more dockers may be listed and the action is run against each one in turn.

Start, stop, restart are all pretty straight forward,  Status prints the ```docker ps``` for the specified docker(s).  Update causes the git repo to be updated and destgroy does s top and remove on the scefied

Start all dockers:

    openag start

View status:

    openag

Stop CoVE:

    openag stop cove

Destroy D-Portal and geocoder:

    openag destroy dportal geocoder

Import and reset
----------------

These commands take data and inject it into the tool.  CoVE and D-Portal both support import.  Reset will wipe the current D-Portal DB.  CoVE will respond with path compoement of the URL required to get the file data and can be run repeatedly.  The D-Portal adds the XML data to the exisiting database, skipping duplicate activities.  D-Portal will import ALL xml documents in it's upload folder so clear out unwanted docuemnts first.  The default location is ```$HOME/.openag/data/dportal```

### Examples

Clean the D-Portal database:

    openag reset dportal

Upload a file into CoVE

    openag import cove ../cove/sample-data/before_enrichment_activities.xml

Upload a file into DPortal

    openag import dportal ../cove/sample-data/before_enrichment_activities.xml
