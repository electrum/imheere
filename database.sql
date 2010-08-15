create table user_location (
  user_id bigint not null
, location_id bigint not null
, status nvarchar(150) not null
, user_name nvarchar(100) not null
, create_dt timestamp not null default now()
, key (user_id)
, key (location_id)
);

create table user_comment (
  user_id bigint not null
, from_id bigint not null
, from_name nvarchar(100) not null
, message nvarchar(150) not null
, create_dt timestamp not null default now()
, key (user_id)
, key (from_id)
);
