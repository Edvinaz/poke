# POKE 3000

Start project
``docker-compose up -d``

Run migrations
``docker exec poke-php-1 php src/Database/migrations.php``

Import Users list from csv
``docker exec poke-php-1 php src/commands/ImportUsers.php``

Import pokes from JSON
``docker exec poke-php-1 php src/commands/ImportPokes.php``
