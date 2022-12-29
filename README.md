# Configuration

преопределение штатного класса сущности

    gallery:
        db_driver: orm модель данных
        factory: App\Gallery\Factory\GalleryFactory фабрика для создания объектов,
                 недостающие значения можно разрешить только на уровне Mediator
        entity: App\Gallery\Entity\Gallery сущность
        constraints: Вкл/выкл проверки полей сущности по умолчанию 
        dto_class: App\Gallery\Dto\GalleryDto класс dto с которым работает сущность
        decorates:
          command - декоратор mediator команд галлереи
          query - декоратор mediator запросов галлереи
        services:
          pre_validator - переопределение сервиса валидатора галлереи
          handler - переопределение сервиса обработчика сущностей
          file_system - переопределение сервиса сохранения файла

# CQRS model

Actions в контроллере разбиты на две группы
создание, редактирование, удаление данных

        1. putAction(PUT), postAction(POST), deleteAction(DELETE)
получение данных

        2. getAction(GET), criteriaAction(GET)

каждый метод работает со своим менеджером

        1. CommandManagerInterface
        2. QueryManagerInterface

При переопределении штатного класса сущности, дополнение данными осуществляется декорированием, с помощью MediatorInterface


группы  сериализации

    1. API_GET_GALLERY, API_CRITERIA_GALLERY - получение галлереи
    2. API_POST_GALLERY - создание галлереи
    3. API_PUT_GALLERY -  редактирование галлереи

# Статусы:

    создание:
        галлерея создана HTTP_CREATED 201
    обновление:
        галлерея обновлена HTTP_OK 200
    удаление:
        галлерея удалена HTTP_ACCEPTED 202
    получение:
        галлерея найдена HTTP_OK 200
    ошибки:
        если галлерея не найдена GalleryNotFoundException возвращает HTTP_NOT_FOUND 404
        если галлерея не уникальна UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если галлерея не прошла валидацию GalleryInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если галлерея не может быть сохранена GalleryCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

# Constraint

Для добавления проверки поля сущности gallery нужно описать логику проверки реализующую интерфейс Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface и зарегистрировать сервис с этикеткой evrinoma.gallery.constraint.property

    evrinoma.gallery.constraint.property.custom:
        class: App\Gallery\Constraint\Property\Custom
        tags: [ 'evrinoma.gallery.constraint.property' ]

## Description
Формат ответа от сервера содержит статус код и имеет следующий стандартный формат
```text
    [
        TypeModel::TYPE => string,
        PayloadModel::PAYLOAD => array,
        MessageModel::MESSAGE => string,
    ];
```
где
TYPE - типа ответа

    ERROR - ошибка
    NOTICE - уведомление
    INFO - информация
    DEBUG - отладка

MESSAGE - от кого пришло сообщение
PAYLOAD - массив данных

## Notice

показать проблемы кода

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose --diff --dry-run
```

применить исправления

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php
```

# Тесты:

    composer install --dev

### run all tests

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests --teamcity

### run personal test for example testPost

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests/Functional/Controller/ApiControllerTest.php --filter "/::testPost( .*)?$/" 

## Thanks

## Done

## License
    PROPRIETARY
   