--Remember to change the options for production!!!

CREATE EXTENSION postgres_fdw;

CREATE SERVER campus_server
FOREIGN DATA WRAPPER postgres_fdw
OPTIONS (host 'localhost', port '5432', dbname 'campus');

CREATE USER MAPPING FOR homestead
SERVER campus_server
OPTIONS (user 'homestead', password 'secret');

CREATE FOREIGN TABLE public.student (
    id integer,
    "user" integer,
    first_name text,
    last_name text,
    gender text,
    date_of_birth date,
    nationality integer,
    graduation_achieved integer,
    generated_email text,
    study_program_id integer,
    created_at timestamp(0) with time zone,
    updated_at timestamp(0) with time zone,
    address text,
    confirmed boolean,
    current_address text,
    current_country character varying(50),
    legal_status_id integer,
    onboarding_page integer,
    latitude double precision,
    longitude double precision,
    map_bounds_north double precision,
    map_bounds_south double precision,
    map_bounds_east double precision,
    map_bounds_west double precision,
    geocode_result json,
    current_city character varying(50),
    buddy_preferred_gender character varying(50),
    send_study_guides boolean,
    hours_per_week double precision,
    phone text) SERVER campus_server OPTIONS (schema_name 'public', table_name 'student');
