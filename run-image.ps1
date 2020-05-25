docker-compose -f "docker-compose.yml" up -d --build
# docker build -t drukpol3d_dev:latest .

docker stop $(docker ps -a -q)

docker run --rm -p 5000:80 -d drukpol3d_dev:latest