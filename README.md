# Transactions ![CI status](https://img.shields.io/badge/build-passing-brightgreen.svg)

Prueba de sistema CRUD.

## Installation

### Requirements
* Git
* PHP >= 7.1.3
* MySQL o MariaDB
* Composer

## Pasos
```
$ git clone https://github.com/bryanzavala/test.git
$ cd test

Copia `.env.example` a `.env` y configura los datos

$ php artisan key:generate
$ composer install
$ php artisan migrate
$ php artisan db:seed
$ php artisan serve
```

## Uso

Es una aplicación de una sola página. Encontrarás todas las funciones en la misma.
* Saldo total (parte superior a la derecha)
* Crear registro (click en `crear registro`)
* Editar registro (click en `editar` a la derecha del registro que se desea editar)
* Borrar registro (click en `borrar` a la derecha del registro que se desea borrar)
* Botones para `copiar`, `csv`, `excel`, `pdf` e `imprimir` en la parte superior de la tabla
* Filtro por `naturaleza` y `beneficiario` en la parte superior de la tabla.
* Mensajes de operaciones (crear, editar, eliminar) en la parte superior de la aplicación.
