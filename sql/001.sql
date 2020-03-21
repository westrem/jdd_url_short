create table links
(
	id varchar(200) not null,
	link TEXT null,
	instant boolean default false not null,
	custom boolean default false not null,
	created_at TIMESTAMP default CURRENT_TIMESTAMP null,
	deleted_at TIMESTAMP null,
	paused_at TIMESTAMP null,
	title TEXT null,
	description TEXT null,
	og_image TEXT null,
	constraint links_pk
		primary key (id)
);

create table stats
(
	id int auto_increment,
	link_id TEXT not null,
	ip INT UNSIGNED null,
	ua TEXT null,
	ref TEXT null,
	created_at TIMESTAMP default CURRENT_TIMESTAMP not null,
	constraint stats_pk
		primary key (id)
);

ALTER TABLE links CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

