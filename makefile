run: # Run the PHP built-in server for public directory
	php -S localhost:8000 -t public

dump-db:
	docker exec -t pem_web_postgres pg_dump -U postgres postgres > dump.sql