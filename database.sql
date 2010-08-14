create table user_at_location (
  user_id bigint not null
, location_id bigint not null
, status nvarchar(150) not null
, create_dt timestamp not null default now()
, primary key(user_id, location_id)
, key(user_id)
, key(location_id)
)
;

create table user_comment (
  user_id bigint not null
, from_id bigint not null
, message nvarchar(150) not null
, create_dt timestamp not null default now()
, primary key(user_id, from_id)
, key(user_id)
, key(from_id)
)
;

