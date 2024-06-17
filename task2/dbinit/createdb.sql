CREATE TABLE `content`
(
    `id`      int          NOT NULL,
    `version` int          NOT NULL,
    `content` varchar(250) NOT NULL
);

ALTER TABLE `content` ADD PRIMARY KEY( `id`, `version`);

INSERT INTO `content`
VALUES (1, 1, 'first id, version one'),
       (1, 2, 'first id, second version'),
       (2, 1, 'second id, first version'),
       (3, 1, 'third id, first version'),
       (1, 3, 'first id, third version'),
       (2, 2, 'second id, second version'),
       (3, 2, 'third id, second version'),
       (1, 4, 'first id, fourth version'),
       (5, 1, 'fifth id, first version'),
       (3, 3, 'third id, third version'),
       (2, 3, 'second id, third version'),
       (2, 4, 'second id, fourth version'),
       (1, 5, 'first id, fifth version');