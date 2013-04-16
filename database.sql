CREATE TABLE usersonline (
  timestamp int(15) DEFAULT '0' NOT NULL,
  ip varchar(40) NOT NULL,
  file varchar(100) NOT NULL,
  PRIMARY KEY (timestamp),
  KEY ip (ip),
  KEY file (file)
);