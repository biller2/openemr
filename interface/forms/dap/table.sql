CREATE TABLE IF NOT EXISTS `dap` (
    /* both extended and encounter forms need a last modified date */
    date datetime default NULL comment 'last modified date',
    /* these fields are common to all encounter forms. */
    id bigint(20) NOT NULL auto_increment,
    pid bigint(20) NOT NULL default 0,
    user varchar(255) default NULL,
    groupname varchar(255) default NULL,
    authorized tinyint(4) default NULL,
    activity tinyint(4) default NULL,
    providername varchar(255),
    typeoftherapy varchar(255),
    cpt varchar(255),
    client varchar(15),
    dos varchar(15),
    location varchar(255),
    duration varchar(15),
    starttime varchar(15),
    endtime varchar(15),
    txgoal1 varchar(15),
    txgoal2 varchar(255),
    data TEXT,
    assassment TEXT,
    plan TEXT,
    provider int(11) default NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB;
INSERT IGNORE INTO list_options SET list_id='lists',
    option_id='provider',
    title='Provider';
INSERT IGNORE INTO list_options SET list_id='provider',
    option_id='1',
    title='Roy Bickel, LCSW',
    seq='1';
INSERT IGNORE INTO list_options SET list_id='lists',
    option_id='cpt',
    title='CPT';
INSERT IGNORE INTO list_options SET list_id='cpt',
    option_id='1',
    title='90791',
    seq='1';
INSERT IGNORE INTO list_options SET list_id='cpt',
    option_id='2',
    title='90832',
    seq='2';
INSERT IGNORE INTO list_options SET list_id='cpt',
    option_id='3',
    title='90834',
    seq='3';
INSERT IGNORE INTO list_options SET list_id='cpt',
    option_id='4',
    title='90837',
    seq='4';
INSERT IGNORE INTO list_options SET list_id='cpt',
    option_id='5',
    title='90846',
    seq='5';
INSERT IGNORE INTO list_options SET list_id='cpt',
    option_id='6',
    title='90847',
    seq='6';
INSERT IGNORE INTO list_options SET list_id='lists',
    option_id='typeoftherapy',
    title='Type Of Therapy';
INSERT IGNORE INTO list_options SET list_id='typeoftherapy',
    option_id='1',
    title='Individual Therapy Note',
    seq='1';
INSERT IGNORE INTO list_options SET list_id='typeoftherapy',
    option_id='2',
    title='Family Therapy Note',
    seq='2';
INSERT IGNORE INTO list_options SET list_id='lists',
    option_id='location',
    title='Location';
INSERT IGNORE INTO list_options SET list_id='location',
    option_id='1',
    title='Foster Placement',
    seq='1';
INSERT IGNORE INTO list_options SET list_id='location',
    option_id='2',
    title='Office',
    seq='2';
INSERT IGNORE INTO list_options SET list_id='lists',
    option_id='txgoal',
    title='txgoal';
INSERT IGNORE INTO list_options SET list_id='txgoal',
    option_id='1',
    title='Cognitive Behavioral Oriented',
    seq='1';
INSERT IGNORE INTO list_options SET list_id='txgoal',
    option_id='2',
    title='Face to Face Visit',
    seq='2';
INSERT IGNORE INTO list_options SET list_id='txgoal',
    option_id='3',
    title='Insight Oriented',
    seq='3';
INSERT IGNORE INTO list_options SET list_id='txgoal',
    option_id='4',
    title='Supportive Psychotherapy',
    seq='4';

