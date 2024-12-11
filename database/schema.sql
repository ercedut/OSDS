CREATE TABLE IF NOT EXISTS users (
    id int auto_increment primary key,
    username varchar(255) not null unique,
    password varchar(255) not null,
    des_key varchar(255) not null
);

CREATE TABLE IF NOT EXISTS requests (
    id int auto_increment primary key,
    student_id int not null,
    document_type varchar(255) not null,
    status varchar(50) not null default 'pending',
    foreign key (student_id) references users(id)
);

CREATE TABLE IF NOT EXISTS encryption_keys (
    id int auto_increment primary key,
    key_value varchar(255) not null,
    created_at timestamp default current_timestamp
);

CREATE TABLE IF NOT EXISTS sensitive_data (
    id int auto_increment primary key,
    user_id int not null,
    encrypted_data text not null,
    foreign key (user_id) references users(id)
);
