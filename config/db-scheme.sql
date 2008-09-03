create table posts (
    id integer primary key autoincrement,
    category_id integer,
    title varchar(255),
    contents text
);
