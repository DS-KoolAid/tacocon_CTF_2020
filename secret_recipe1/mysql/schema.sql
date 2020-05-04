SET GLOBAL event_scheduler = ON;
USE tacocon;

CREATE TABLE login_storage (
name char(64),
secret char(64),
message varchar(512)
);

DELIMITER //

CREATE PROCEDURE init_contents_proc()
  LANGUAGE SQL
  BEGIN
    INSERT INTO login_storage VALUES ('admin','FFXisvALLmqDNxyMdwek44yYfziZHQFZdx',"Hello Admin! Here is the secret recipe: Tacocon{}");
  END //

CREATE EVENT cronjob
  ON SCHEDULE EVERY 2 MINUTE
  DO
    BEGIN
      TRUNCATE TABLE login_storage;
      CALL init_contents_proc();
    END //

DELIMITER ;