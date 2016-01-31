SET FOREIGN_KEY_CHECKS=0;

drop table if exists t_user;
create table t_user(
	user_id		int unsigned not null auto_increment primary key,
	user_name		varchar(30) unique,
	password		varchar(30),
	name			varchar(200),
	address			varchar(200),
	mobile			varchar(30),
	fax				varchar(30),
	email			varchar(100),
	status			tinyint, --0 normal ,1 disable
	create_time		DATETIME
);


drop table if exists t_content;
create table t_content(
	content_id	int unsigned not null auto_increment primary key,
	name varchar(100), -- content name
	title varchar(200), -- sms content, mms title.
	type	tinyint,  -- 0 sms ,1 mms
	create_time DATETIME
);

drop table if exists t_content_mms;
create table t_content_mms(
	frame_id int unsigned not null auto_increment primary key,
	content_id	int unsigned,
	img_file	varchar(200),
	txt_file	varchar(200),
	duration		int,
	constraint fk_content_id foreign key (content_id) references t_content(content_id) on delete cascade
);


drop table if exists t_send_task;
create table t_send_task(
	task_id int unsigned not null auto_increment primary key,
	name varchar(100),
	user_id int unsigned,
	content_id int unsigned,
	send_date DATETIME,
	time_zone int,
	mobile_file varchar(200), -- if use t_mobile_db, content is like "db:db_id1,db_id2..."
	create_date	DATETIME,
	description	varchar(500),
	state int default 0,  -- 0 waiting for send,1 sending,2 send fail,3.send finished
	finished_date DATETIME,
	finished_info varchar(500),
	server_date DATETIME,
	region varchar(10),
	constraint fk_send_task_user_id foreign key (user_id) references t_user(user_id) on delete cascade
);

drop table if exists t_black_list;
create table t_black_list(
	black_id int unsigned not null auto_increment primary key,
	mobile varchar(100)
);

drop table if exists t_blacked_list;
create table t_blacked_list(
	blacked_id int unsigned not null auto_increment primary key,
	task_id int unsigned,
	mobile varchar(100),
	constraint fk_blacked_list_task_id foreign key (task_id) references t_send_task(task_id) on delete cascade
);

drop table if exists t_mobile_db;
create table t_mobile_db(
	db_id int unsigned not null auto_increment primary key,
	name varchar(100),
	user_id int unsigned,
	mobile_file varchar(200),
	constraint fk_mobile_db_user_id foreign key (user_id) references t_user(user_id) on delete cascade
);
