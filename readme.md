## Установка

После базовой конфигурации Laravel 5.4 <a href="https://laravel.com/docs/5.4/configuration">настройка</a>

Необходимо выполнить следующие команды:
```bash
php artisan migrate //создаёт структуру таблиц
```
```bash
php artisan db:seed  //заполняет таблицу начальными данными
```

## Регистрация пользователей 
Регистрация пользователей происходит через консольную команду:

```bash
php artisan user:registration
```

После чего следовать инструкции в консоле


## Запросы

- **Вывод всех категорий**

`GET: /api/categories`

Запрос:
```bash
$ curl -X GET http://profi-test.nn-rus.ru/api/categories
```
Ответ:
```javascript
{
  status: "Ok",
  data: [ //массив с категориями
    {
      id: 1, //числовой идентификатор модели Category
      category_name: "Автомобили" //название категории
    },
   ...
  ]
}
```
- **Вывод товаров из категории**

`GET: category/{id категории}/goods`

Запрос:
```bash
$ curl -X GET http://profi-test.nn-rus.ru/api/category/1/goods

```
Ответ:
```javascript
{
  status: "Ok",
  data: [ //массив с категориями
    {
      id: 1, //числовой идентификатор модели Goods
      goods_title: "Газель", //название товара
      goods_description: "маневренный автомобиль, предназначенный для грузопассажирских перевозок", //описание товара
      created_at: "2017-12-10 22:25:48", //дата создания
      updated_at: "2017-12-10 22:25:48", //дата изменения
      pivot: {
        category_id: 1, //идентификатор какой категории принадлеэит товар
        goods_id: 1     //идентификатор товара
      }
    },
   ...
  ]
}
```
Для следующих запросов необходим `api_token` полученый в ответе после авторизации.

Его необходимо добавлять в `Header` запроса:

```javascript
{ 'Authorization': 'api_token' }
```

- **Авторизация**

`POST: /api/auth`

Запрос:
```bash
$ curl -X POST http://profi-test.nn-rus.ru/api/auth \
-H "Accept: application/json" \
-H "Content-type: application/json" \
-d "{\"email\": \"test-user@test.test\",  //email зарегистрированного пользователя
\"password\": \"test-user@test.test\" }" //пароль

```
Ответ:
```javascript
{
  status: "Ok",
  data: { 
    id: 1,                        //идентификатор пользователя
    name: "test-user",            //имя пользователя
    email: "test-user@test.test", //почта пользователя 
    api_token: "5dd907958bb4e92fd416c8c423629839890fbff4c2bdebb8a37f1685b9a0", //токен
    created_at: "2017-12-10 22:25:47", //дата регистрации
    updated_at: "2017-12-11 21:52:08"  //дата изменения
  }
}
```

- **Создание категории**

`POST: /api/category`

Запрос:
```bash
$ curl -X POST http://profi-test.nn-rus.ru/api/category \
-H "Accept: application/json" \
-H "Content-type: application/json" \
-H "Authorization: 5dd907958bb4e92fd416c8c423629839890fbff4c2bdebb8a37f1685b9a0" \
-d "{\"category_name\": \"Новая категория\"}"

```
Ответ:
```javascript
{
  status: "Ok",
  data: {
    category_name: "Новая категория",  //название категории
    updated_at: "2017-12-11 21:59:32", //дата создани
    created_at: "2017-12-11 21:59:32", //дата изменения
    id: 8 //идентификатор новой категории
  }
}
```

- **Изменение категории**

`PUT: /api/category/{id категории}`

Запрос:
```bash
$ curl -X PUT http://profi-test.nn-rus.ru/api/category/1 \
-H "Accept: application/json" \
-H "Content-type: application/json" \
-H "Authorization: 5dd907958bb4e92fd416c8c423629839890fbff4c2bdebb8a37f1685b9a0" \
-d "{\"category_name\": \"Изменённая категория\"}"

```
Ответ:
```javascript
{
  status: "Ok",
  data: {
    category_name: "Изменённая категория",  //название категории
    updated_at: "2017-12-10 22:25:47",      //дата создани
    created_at: "2017-12-11 22:07:02",      //дата изменения
    id: 1 //идентификатор категории
  }
}
```

- **Удаление категории (вместе с категорией удаляются торы содержащиеся в ней)**

`DELETE: /api/category/{id категории}`

Запрос:
```bash
$ curl -X DELETE http://profi-test.nn-rus.ru/api/category/10 \
-H "Accept: application/json" \
-H "Content-type: application/json" \
-H "Authorization: 5dd907958bb4e92fd416c8c423629839890fbff4c2bdebb8a37f1685b9a0"
```
Ответ:
```javascript
{
  status: "Ok",
  data: {
    delete: "Удаление прошло успешно" //сообщение об успешном удалении
  }
}
```

- **Создание товара**

`POST: /api/goods`

Запрос:
```bash
$ curl -X POST http://profi-test.nn-rus.ru/api/goods \
        -H "Accept: application/json" \
        -H "Content-type: application/json" \
        -H "Authorization: 5dd907958bb4e92fd416c8c423629839890fbff4c2bdebb8a37f1685b9a0"\
        -d "{\"goods_title\": \"Название товара\", \"goods_description\": \"Описание товара\", 
        \"categories\": [1, 2] }" //одна или несколько категорий в формате массива (Array)
```
Ответ:
```javascript
{
  status: "Ok",
  data: {
    goods_title: "Название товара",       //название нового товара
    goods_description: "Описание товара", //его описание
    updated_at: "2017-12-11 22:24:18",    //дата создания
    created_at: "2017-12-11 22:24:18",    //дата изменения
    id: 14                                //идентификатор созданного товара
  }
}
```

- **Изменение товара**

`PUT: /api/goods/{id товара}`

Запрос:
```bash
$ curl -X PUT http://profi-test.nn-rus.ru/api/goods/14 \
        -H "Accept: application/json" \
        -H "Content-type: application/json" \
        -H "Authorization: 5dd907958bb4e92fd416c8c423629839890fbff4c2bdebb8a37f1685b9a0"\
        -d "{\"goods_title\": \"Изменённое название товара\", \"goods_description\": \"Изменённое описание товара\", \"categories\": [1] }"
```
Ответ:
```javascript
{
  status: "Ok",
  data: {
    id: 14,                                          //идентификатор товара
    goods_title: "Изменённое название товара",       //название изменённого товара
    goods_description: "Изменённое описание товара", //название изменённого товара
    created_at: "2017-12-11 22:24:18",               //дата создания
    updated_at: "2017-12-11 22:27:21"                //дата изменеия
  }
}
```

- **Удаление товара**

`DELETE: /api/goods/{id товара}`

Запрос:
```bash
$ curl -X DELETE http://profi-test.nn-rus.ru/api/goods/14 \
-H "Accept: application/json" \
-H "Content-type: application/json" \
-H "Authorization: 5dd907958bb4e92fd416c8c423629839890fbff4c2bdebb8a37f1685b9a0"
```
Ответ:
```javascript
{
  status: "Ok",
  data: {
    delete: "Удаление прошло успешно" //сообщение об успешном удалении
  }
}
```
- **Выход из приложения (удаление api_token привязанного к пользователю)**

`POST: /api/api_logout`

Запрос:
```bash
$ curl -X POST http://profi-test.nn-rus.ru/api/api_logout \
-H "Accept: application/json" \
-H "Authorization: 5dd907958bb4e92fd416c8c423629839890fbff4c2bdebb8a37f1685b9a0" 

```
Ответ:
```javascript
{
  status: "Ok",
  data: {
    user: "Вы успешно вышли"
  }
}
```
После выхода токен является недействительным


## Тестирование

Тесты находятся в папке `tests/Feature`

Команда для запуска тестирования:
```bash
php composer test
```
Тесты использут базу данных `sqlite` просьба убедится, что в системе установел соответствующий драйвер для работы с ней

## Превью

Демо версия доступна по адресу  <a href="http://profi-test.nn-rus.ru/" target='_blank'>profi-test.nn-rus.ru</a>

Представлен веб интерфейс для отправки API запросов
