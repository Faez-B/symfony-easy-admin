up:
	docker compose up --build
#   docker exec -it symfony symfony console doctrine:schema:update --force --complete
#	docker exec symfony bash -c "symfony console doctrine:schema:update --force --complete"

down:
	docker compose down
	docker system prune -a
	docker ps -aq | xargs docker stop | xargs docker rm
	docker images -aq | xargs docker rmi
	docker volume prune

inside:
	docker exec -it symfony symfony console doctrine:schema:update --force --complete