CREATE DATABASE IF NOT EXISTS agrovoc_autocode;
CREATE TABLE `agrovoc_autocode`.`agrovoc_terms` (
    L1 varchar(128) DEFAULT NULL,
    L2 varchar(128) DEFAULT NULL,
    L3 varchar(128) DEFAULT NULL,
    L4 varchar(128) DEFAULT NULL,
    L5 varchar(128) DEFAULT NULL,
    L6 varchar(128) DEFAULT NULL,
    L7 varchar(128) DEFAULT NULL,
    Code  varchar(128) DEFAULT NULL,
    `Use?` varchar(128) DEFAULT NULL
);
source /opt/autocoder/db/create_hierarchy_table.sql
