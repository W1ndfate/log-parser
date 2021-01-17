## API Apache Logs Parser


### Установка
-------------------

1. Скачиваем
    ```
    git@github.com:W1ndfate/log-parser.git
    ```
2. Устанавлием зависимости `composer install`
3. Инициализируем проект `php init`
4. Создаем пустую базу данных PostgreSQL
5. Указываем подключение к БД в файле `common\config\main-local.php`
    ```
   <?php
   
   return [
       'components' => [
           'db' => [
               'class' => 'yii\db\Connection',
               'dsn' => "pgsql:host=localhost;port=5432;dbname=test_db",
               'username' => '',
               'password' => '',
               'charset' => 'utf8',
           ]
       ],
   ];
    ```
6. Выполняем миграции `php yii migrate/up`
7. (опционально) Запускаем тестовый локальный php-сервер из папки `api\web` командой `php -S localhost:8000`


### Точки доступа API
-------------------

- `POST v1/login` - Авторизация для получения ключа доступа. Параметры тела запроса:  
    - username (обязательный)
    - password (обязательный)
- `POST v1/register` - Регистрация нового пользователя. Параметры тела запроса: 
    - username (обязательный, уникальный)
    - password (обязательный)
    - email (обязательный, уникальный)
- `GET  v1/apache-logs` - Получение логов из БД. Авторизация с помощью Bearer Token. Параметры запроса:
    - сount (необязательный, integer, по умолчанию - 100)
    - timeFrom - время "от" (необязательный, timestamp)
    - timeTo - время "до" (необязательный, timestamp)
    - host - фильтр по IP-адресу (необязательный, string)


### Консольные приложение
-------------------

#### Настройка

1. Указываем настройки парсера в файле параметров `console\config\params-local.php`
    ```
   <?php
   return [
       'apacheParser' => [
           'workdir' => '/var/www/runtime/apache-logs',
           'logFormat' => '%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-agent}i\"',
           'logFileMasks' => ['access*.log']
       ]
   ];
    ```
2. (опционально) Запуск в крон: в файл конфигурации cron записываем последовательность и частоту выполнения команд из списка. Пример:
    ```
    # Пример запуска скрипта в 5 утра каждый день:
    0 5 * * * /usr/bin/php /home/www/log-parser yii parser/parse-apache
    ```

#### Команды

`php yii parser/parse-apache` - парсит и записывает в БД Apache-логи из файлов