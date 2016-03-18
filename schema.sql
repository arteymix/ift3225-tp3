create table users (
    id            integer       unsigned primary key auto increment,
    username      varchar(127),
    email         varchar(127),
    password_hash char(60),
    admin         boolean       default false
);

create table wikis (
    id        integer      unsigned primary key auto increment,
    title     varchar(127) not null,
    author_id integer,
    document  text         not null,
    created   timestamp    default CURRENT_TIMESTAMP
);
