## Задание

#### Требования к стеку технологий:
* PHP 8, Laravel ^10
* Postgres / MySQL
* jQuery / Vue
* SCSS / CSS, Bootstrap 5

*При создании базы использовать миграции Laravel*<br>
*Для JS и CSS/SCSS использовать Laravel Mix/Vite*

#### Структура БД:
* таблица пользователей
* таблица баланса пользователя
* таблица операций

#### Структура сайта:
* Логин
* Главная страница отображает текущий баланс пользователя и пять последних операций обновление всех данных через T секунд (ajax)
* История операциа отображает таблицу операций с сортировкой по полю “дата” и поиском по полю “описание”


#### Бэкенд
*Через консольную команду (artisan) сделать:*
* Добавление пользователей
* Проведение операций по балансу пользователя, по логину (начисление/списание) с указанием описания операции, не давать уводить баланс в минус


*Отдельным плюсом будет реализация проведения операций по балансу с использованием Laravel Queues*

*Результат работы выложить в любой общедоступный Git репозиторий (Github, Bitbucket и пр.)* 


## Комментарии к решению
* Проект содержит всё необходимое окружение в контейнерах для быстрой проверки
* На бэкенде тестами покрыта только основная логика. Используются интеграционные тесты. Юнит тестов нет, так как для этого нужно продумывать более сложную архитектуру, поскольку по умолчанию Laravel имеет довольно сильную связанность (coupling) компонентов и замокать внешние зависимости очень сложно
* На фронтенде тесты не покрыты вообще, так как логики почти нет
* В идеале, чтобы решить проблему юнит тестирования я бы для начала заменил Eloquent на Laravel Doctrine и использовал паттерн "Репозиторий" для отделения логики от хранения данных
* По условиям задаче нужно использовать очереди. Я использую очереди напрямую, но в идеале для более сложных кейсов лучшим решением было бы организовать событийно-ориентированный подход взаимодействия между компонентами
* Содержится потенциальная проблема атомарности. Так как очереди имеют асинхрнную природу, то очень сложно обернуть весь бизнес-процесс в обычную транзакцию БД. Для решения этой проблемы можно использовать паттерн "Сага" и компенсирующие транзакции, но это избыточно для простой задачи