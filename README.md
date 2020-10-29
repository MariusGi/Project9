Main routes:
localhost:8080/login
localhost:8080/register
localhost:8080/contacts

LINUX LAUNCH:
1. git clone https://github.com/MariusGi/Project9.git
2. cd Project9/
3. docker-compose up -d -build
4. apt install php-xml (if you don't have php-xml)
5. composer install
6. php bin/console doctrine:database:create
7, php bin/console doctrine:migrations:migrate
