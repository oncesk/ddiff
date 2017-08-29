# ddiff
Data diff tool

## For what?

Was you in situations where you need to compare data and do something with diff data? Yes, and what if we need compare mysql 
data with remote server? What if you need compare data from csv file and mysql server?

Yes, this tool can helps you.

## Features

Currently available

 - for mysql calculation just one table per command call
 - calculate diff between two databases (mysql for now)
 - calculate diff between csv and database (mysql for now)
 - calculate diff between csv and csv
 - write diff in stdout, file
 - format diff in sql format with INSERT, UPDATE, DELETE statements

In the future

 - compare full database
 - compare by table mask
 - add additional sources (json, xml)
 - compare csv, json, xml