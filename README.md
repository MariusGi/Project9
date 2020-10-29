Main routes:
localhost:8080/login
localhost:8080/register
localhost:8080/contacts

WINDOWS LAUNCH:
1. git clone https://github.com/MariusGi/Project9.git
2. cd Project9/
3. docker-compose up -d -build
4. cd app/
5. composer update
6. php bin/console doctrine:database:create
7. php bin/console doctrine:migrations:migrate
