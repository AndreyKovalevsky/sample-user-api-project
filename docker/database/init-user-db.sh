#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    CREATE USER app_user WITH PASSWORD '7VKkMfINv9p3xHxH';
    CREATE DATABASE app_user;
    GRANT ALL PRIVILEGES ON DATABASE app_user TO app_user;
EOSQL