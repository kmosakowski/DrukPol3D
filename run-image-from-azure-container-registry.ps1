docker login cmswordpresscontainerregistry.azurecr.io
#Name: CmsWordpressContainerRegistry
#Password: TggUaZfg/xuaeZV7pRWeXukfPrhm6rGP

docker pull cmswordpresscontainerregistry.azurecr.io/cms-wordpress-images/test/cms-wordpress-img01:latest
docker stop $(docker ps -a -q)
docker run --rm -e DB_ENV_HOST=cms-wordpress-server01.mysql.database.azure.com:3306 -e DB_ENV_USER=s16392@cms-wordpress-server01 -e DB_ENV_PASSWORD=CmsIsCool69 -e DB_ENV_NAME=cms_wordpress_db_dev01 -p 5000:80 -d cmswordpresscontainerregistry.azurecr.io/cms-wordpress-images/test/cms-wordpress-img01:latest