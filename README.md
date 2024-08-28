# Документация к проекту Salesrep и Driver

#### git https://github.com/boszhansale/BoszhanBackPHP

#### главный домен https://boszhan.kz/

#### админка https://boszhan.kz/admin

#### База данных MySql 5.7

#### php 8.2

все доступы находятся в файле .env

## Контроллеры Админки app/Http/Controllers/Admin

- AuthController это обши контроллер для всех ролей
- BasketController отвечает за логику корзины
- BrandController отвечает за логику бренд и категории
- CategoryController отвечает за логику категории
- CounteragentController отвечает за логику Контрагентов
- CounteragentGroupController группирование контрагентов
- MainController это главый контроллер отвечает за главный страницу (только статистика)
- OrderController заказы
- PlanGroupController планы для ТП
- ProductController вся номенклатура
- RefundController возвраты
- RoleController отвечает за логику Ролей и доступы к ним
- StoreController торговые точки
- UserController пользователи

## контроллеры которые не относиться главному бизнес логике

- LabelProductController это этикетки. не связан c salesrep и driver
- MobileAppController механизм версионирование для android приложение salesrep и driver

## Этикетки

для управление этикетками нужно войти на аккаунт с логином 'etk'
а для печати https://boszhan.kz/label

### api https://boszhan.kz/api

все апи прописаны Boszhan.postman_collection.json

## Контроллеры Апи

- AuthController отвечает за авторизацию пользователей
- BrandController предоставляет список брендов
- CategoryController предоставляет список брендов
- LabelController предоставляет список этикетов
- ProductController предоставляет список продуктов
- StoreController предоставляет список ТТ
-

## Контроллеры Salesrep

- CounteragentController предоставляет список контрагентов
- OrderController отвечает за создание,удаление и изменение заказов
- StoreController отвечает за создание,удаление и изменение ТТ

## Контроллеры Driver

- BasketController предоставляет список продуктов в корзине и редактирование
- OrderController список заказов,изменение статус заказа и печать на принтер-

## Консольные команды Artisan

- edi:parse парсит xml файл с фтп сервера
- edi:clear удаляет xml файлы с фтп сервера
- order:delivery меняет статус заказа на 2
- order:report выгружает заказы на 1с
- order:report-return выгружает возвраты на 1с
- counteragent_user:copy {from} {to} копирует контрагенты с одного узера на другой
- db:backup создает бекап бд
- image:optimize делает оптимизацию фото продуктов
- plan:calk считает суммы для PlanGroup
- store:report отправляет список новый ТТ на почту
- store:report_by_user {user_id} создает excel файл ТТ
- store_salesrep:copy {from} {to} копирует ТТ с одного узера на другой
