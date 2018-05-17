TRUNCATE TABLE lightstatus;
LOAD DATA LOCAL INFILE '/var/www/exec/import_status/lightstatus.txt' INTO TABLE lightstatus FIELDS TERMINATED BY ',';
select * from lightstatus;
