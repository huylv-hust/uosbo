ALTER TABLE `job`
CHANGE COLUMN `trouble` `trouble` VARCHAR(1000) NULL COMMENT 'Save ,code,code,code,code,' ;

UPDATE job SET trouble = REPLACE(trouble, ',1,', ',nearstation,');
UPDATE job SET trouble = REPLACE(trouble, ',2,', ',car,bike,');
UPDATE job SET trouble = REPLACE(trouble, ',3,', ',beginner,');
UPDATE job SET trouble = REPLACE(trouble, ',4,', ',college,');
UPDATE job SET trouble = REPLACE(trouble, ',5,', ',food,');
UPDATE job SET trouble = REPLACE(trouble, ',6,', ',fashion,');
UPDATE job SET trouble = REPLACE(trouble, ',7,', ',school,');
UPDATE job SET trouble = REPLACE(trouble, ',8,', ',hair,');
UPDATE job SET trouble = REPLACE(trouble, ',9,', ',daily,weekly,');
UPDATE job SET trouble = REPLACE(trouble, ',10,', ',weekend,');
UPDATE job SET trouble = REPLACE(trouble, ',11,', ',now,');
UPDATE job SET trouble = REPLACE(trouble, ',12,', ',free,');
UPDATE job SET trouble = REPLACE(trouble, ',13,', ',earns,');
UPDATE job SET trouble = REPLACE(trouble, ',14,', ',english,');
UPDATE job SET trouble = REPLACE(trouble, ',15,', ',housewife,');
UPDATE job SET trouble = REPLACE(trouble, ',16,', ',doublework,');
UPDATE job SET trouble = REPLACE(trouble, ',17,', ',no_licenses,');
UPDATE job SET trouble = REPLACE(trouble, ',18,', ',female,');
UPDATE job SET trouble = REPLACE(trouble, ',19,', ',self,');
UPDATE job SET trouble = REPLACE(trouble, ',20,', ',full,');
UPDATE job SET trouble = REPLACE(trouble, ',21,', ',night,');
UPDATE job SET trouble = REPLACE(trouble, ',22,', ',short,');
UPDATE job SET trouble = REPLACE(trouble, ',23,', ',transportation,');
UPDATE job SET trouble = REPLACE(trouble, ',24,', ',shiftsys,');
UPDATE job SET trouble = REPLACE(trouble, ',25,', ',employment,');
UPDATE job SET trouble = REPLACE(trouble, ',26,', ',openning,');
