# User API app

## Requirements

You will need to have:
- docker: https://docs.docker.com/get-docker/
- docker-compose: https://docs.docker.com/compose/install/

## Local Installation and Use

Build images:
```bash
make build
```

Run images:
```bash
make up
```

Install dependencies:
```bash
make composer-install
```

Initialize database (run migrations):
```bash
make init-db
```

Stop containers:
```bash
make down
```

## Documentation
You can access documentation on `/api/doc`

OpenAPI Specification in JSON available on `/api/doc.json`


## Unit tests

Run all tests of the application:
```bash
make run-phpunit
```

## Notes

### Tech Stack
- Docker
- PHP 8
- PostgreSQL
- Nginx
- NelmioApiDocBundle (for documentation)

### To improve
- NelmioApiDocBundle on current version doesn't support PHP 8 attributes but it's in development. Once it will be updated it's worth updating the app to use attributes instead of PHPDoc annotations.
- If an application gets more complex it can be worth considering using The Serializer Component to return data based on different rules. 
- To make development easy and faster it can be better to use API Platform which is a full stack framework dedicated to API-driven projects.
