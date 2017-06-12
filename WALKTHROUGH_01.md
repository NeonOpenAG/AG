Walkthrough 01
==============

The first and simplest script for passing data through the application.

 1. Data in CSV format is passed into CoVE, uploaded to http://localhost:8008/
 1. Download parsed data in IATI 2 XML ![#f03c15](https://placehold.it/15/f03c15/000000?text=+) IATI default XML does not parse, json is detected as a spreadsheet
 1. I upload [sample data](./geocoder/sample.csv) into the geocoder.
 1. Do some geo coding
 1. Download data from geocoder ![#f03c15](https://placehold.it/15/f03c15/000000?text=+)The export function does not work
 1. Upload data to the classifier (use the remote API for now)
 1. Retrieve suggestions
 1. Integrate suggestions into original document
 1. Upload into D-Portal
 1. Upload into OIPA
