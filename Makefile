.PHONY: up down stop start install
include .env
up:
	docker-compose up -d
down: 
	docker-compose down
stop:
	docker-compose stop
start:
	docker-compose start
install: up
	sleep 5
	docker-compose exec php bash -c "drush site:install --db-url=mysql://$(MYSQL_USER):$(MYSQL_PASS)@$(MYSQL_HOST):$(MYSQL_PORT)/$(MYSQL_DB_NAME) -y"
	docker-compose exec php bash -c "drush user:create --mail=test@example.com --password=test test"
	docker-compose exec php bash -c "drush user:role:add administrator test"
	@mkdir -p "drush"
	@echo "options:\n uri: 'http://$(PROJECT_BASE_URL)'" >  drush/drush.yml
	docker-compose exec php bash -c "drush uli"

cli: 
	docker-compose exec php bash