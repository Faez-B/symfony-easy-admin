up:
	docker compose up --build

down:
	docker compose down
	docker system prune -a
	docker ps -aq | xargs docker stop | xargs docker rm
	docker images -aq | xargs docker rmi
	docker volume prune