TRUNCATE TABLE lightstatus;
LOAD DATA LOCAL INFILE 'lightstatus.txt' INTO TABLE lightstatus FIELDS TERMINATED BY ',';
select * from lightstatus;
