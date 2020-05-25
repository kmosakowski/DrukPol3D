=== Image build:
docker build -t drukpol3d_dev:v1 .

=== App run:
docker run --rm -e DB_ENV_HOST=cms-wordpress-server01.mysql.database.azure.com:3306 -e DB_ENV_USER=s16392@cms-wordpress-server01 -e DB_ENV_PASSWORD=CmsIsCool69 -e DB_ENV_NAME=cms_wordpress_db_dev01 -p 5000:80 -d drukpol3d_dev:latest

=== Other commands
--images
docker images
docker image rm -f [image name:tag]

-- containers
docker stop [nazwa kontenera]
docker stop $(docker ps -a -q) --stop all containers
docker system prune -a -- remove all images and containers