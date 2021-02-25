-- auto-generated definition
create table towns
(
    id   int auto_increment
        primary key,
    town varchar(16) not null,
    constraint towns_town_uindex
        unique (town)
)
    comment 'a list of cities';

INSERT INTO test.towns (id, town) VALUES (6, 'Jõgeva');
INSERT INTO test.towns (id, town) VALUES (5, 'Jõhvi');
INSERT INTO test.towns (id, town) VALUES (3, 'Narva');
INSERT INTO test.towns (id, town) VALUES (4, 'Pärnu');
INSERT INTO test.towns (id, town) VALUES (7, 'Põlva');
INSERT INTO test.towns (id, town) VALUES (1, 'Tallinn');
INSERT INTO test.towns (id, town) VALUES (2, 'Tartu');
INSERT INTO test.towns (id, town) VALUES (8, 'Valga');

create table star_event_registrations
(
    id            int auto_increment
        primary key,
    name          varchar(55)  not null,
    email         varchar(55)  not null,
    town_fk       int          not null,
    event_session int          not null,
    comment       varchar(200) not null
);

