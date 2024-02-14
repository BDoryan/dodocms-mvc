ALTER TABLE Page ADD COLUMN favicon INT (11)   ;
ALTER TABLE Page ADD CONSTRAINT fk_Resources FOREIGN KEY (favicon) REFERENCES Resources(id);
