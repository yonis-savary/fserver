-include .env
export

start-dev:
	@docker compose --env-file ./.env -f Docker/Dev/compose.yml build
	@docker compose --env-file ./.env -f Docker/Dev/compose.yml up -d
start-prod:
	@docker compose --env-file ./.env -f Docker/Prod/compose.yml build
	@docker compose --env-file ./.env -f Docker/Prod/compose.yml up -d

dev:
	@make --no-print-directory start-dev
	@make --no-print-directory post-start-checkups

prod:
	@make --no-print-directory start-prod
	@make --no-print-directory post-start-checkups

post-start-checkups:
	@[ "$$(stat -c %u Docker/app_storage)" = "0" ] && sudo chown "${UID}:${GID}" -R Docker/app_storage || true

deploy:
	@git pull
	@make --no-print-directory prod
	@docker compose --env-file ./.env -f Docker/Prod/compose.yml exec application php do migrate

down:
	@docker compose --env-file ./.env -f Docker/Dev/compose.yml down
	@docker compose --env-file ./.env -f Docker/Prod/compose.yml down

setup:
	@cp .env.example .env
	@ln -s .env Frontend/.env
	@make --no-print-directory dev
	@make --no-print-directory post-start-checkups
	@docker compose --env-file ./.env -f Docker/Dev/compose.yml exec backend php do migrate