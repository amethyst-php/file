# lara-ore-disk

[![Build Status](https://travis-ci.org/railken/lara-ore-disk.svg?branch=master)](https://travis-ci.org/railken/lara-ore-disk)
[![License](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

A laravel package to manage multiple disks saved in the database
# Requirements

PHP 7.0.0 and later.


## Installation

You can install it via [Composer](https://getcomposer.org/) by typing the following command:

```bash
composer require railken/lara-ore-disk
```

The package will automatically register itself.

You can publish the migration with:

```bash
php artisan vendor:publish --provider="Railken\LaraOre\Disk\DiskServiceProvider" --tag="migrations"
```

After the migration has been published you can create the media-table by running the migrations:

```bash
php artisan migrate
```
You can publish the config-file with:

```bash
php artisan vendor:publish --provider="Railken\LaraOre\Disk\DiskServiceProvide" --tag="config"
```

## Configuration
```php

return [

    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    |
    | This is the table used to save disks to the database
    |
    */
    'table' => 'ore_disks',

    /*
    |--------------------------------------------------------------------------
    | Drivers
    |--------------------------------------------------------------------------
    |
    | These are the accepted drivers
    |
    */
    'drivers' => [
        's3' => [
            'key', 
            'secret', 
            'region', 
            'bucket',
            'url'
        ],
        'local' => [
            'root', 
            'url', 
            'visibility'
        ],
    ]
];
```

## Simple Usage

```php
use Railken\LaraOre\Disk\DiskManager;
use Illuminate\Support\Facades\Storage;

$dm = new DiskManager();

// Create a new disk
$result = $dm->create([
    'name' => 'My_Disk',
    'driver' => 's3',
    'config' => [
        'key' => '...',
        'secret' => '...'
        'bucket' => '...'
        'region' => '...'
        'url' => '...'
    ]
    'enabled' => 1
]);

// Retrieve resource 
$resource = $result->getResource(); // Instance of Railken\LaraOre\Disk\Disk

// Retrieve storage method 1
$storage = $resource->getStorage();

// Retrieve storage method 2
$storage = Storage::disk($resource->getStorageName());

// Test files
$storage->put("tmp.txt", "hello");
$url = $storage->temporaryUrl("tmp.txt", (new \DateTime())->modify("+2 hours"));

```

## Retrieving a disk
```php
use Railken\LaraOre\Disk\DiskManager;

$dm = new DiskManager();

$resource = $dm->getRepository()->findOneById(1);
```

## Retrieving all disks
```php
use Railken\LaraOre\Disk\DiskManager;

$dm = new DiskManager();

$resource = $dm->getRepository()->findAll();

```

## Getting an instance of \Illuminate\DataBase\Eloquent\Builder
```php
use Railken\LaraOre\Disk\DiskManager;

$dm = new DiskManager();

$query = $dm->getRepository()->newQuery();

$resource = $query->where('id', 1)->first();

```

## Creating a disk
```php
use Railken\LaraOre\Disk\DiskManager;

$dm = new DiskManager();

$result = $dm->create([
    'name' => 'My-Disk',
    'driver' => 's3',
    'config' => [...]
]);

```

## Updating a disk
```php
use Railken\LaraOre\Disk\DiskManager;

$dm = new DiskManager();

$resource = $dm->getRepository()->findOneById(1);

$result = $dm->update($resource, [
    'name' => 'My-Disk2',
]);

```

## Removing a disk
```php
use Railken\LaraOre\Disk\DiskManager;

$dm = new DiskManager();

$resource = $dm->getRepository()->findOneById(1);

$result = $dm->remove($resource);

```

## Checking the results

```php
use Railken\LaraOre\Disk\DiskManager;

$dm = new DiskManager();

$result = $dm->create([
    'name' => 'My-Disk',
    'driver' => 's3',
    'config' => [...]
]);

if ($result->ok()) {

    $resource = $result->getResource();

} else {

    // Loop through all errors
    $result->getErrors()->map(function($error) {
        return $error->toArray();
    }))

    // Retrieve an array of all errors
    $result->getSimpleErrors();

    /* The result is something like this:

        [0] => Array
            (
                [code] => DISK_NAME_NOT_DEFINED
                [label] => name
                [message] => The name is required
                [value] =>
            )
    */

}
```


## Attributes

| Name       | Required | Unique | Default | Validation                      | Description |
|------------|----------|--------|---------|---------------------------------|-------------|
| id         | /        | /      |         | /                               | /           |
| name       | yes      | yes    | /       | [a-zA-Z0-9_-]                   |             |
| driver     | yes      | no     | /       | local|s3                        |             |
| config     | yes      | no     | /       | s3:key,secret,bucket,region,url |             |
| enabled    | no       | no     | 1       | 1|true|0|false                  |             |
| created_at | /        |        | NOW()   |                                 |             |
| updated_at | /        |        | NOW()   |                                 |             |


## Errors

| Code                        | Message                                      |
|-----------------------------|----------------------------------------------|
| DISK_NAME_NOT_DEFINED       | This attribute is required                   |
| DISK_NAME_NOT_VALID         | This attribute is not valid                  |
| DISK_NAME_NOT_UNIQUE        | This attribute is already taken              |
| DISK_NAME_NOT_AUTHORIZED    | You're not authorized to edit this attribute |
| DISK_DRIVER_NOT_DEFINED     | This attribute is required                   |
| DISK_DRIVER_NOT_VALID       | This attribute is not valid                  |
| DISK_DRIVER_NOT_AUTHORIZED  | You're not authorized to edit this attribute |
| DISK_CONFIG_NOT_DEFINED     | This attribute is required                   |
| DISK_CONFIG_NOT_VALID       | This attribute is not valid                  |
| DISK_CONFIG_NOT_AUTHORIZED  | You're not authorized to edit this attribute |
| DISK_ENABLED_NOT_VALID      | This attribute is not valid                  |
| DISK_ENABLED_NOT_AUTHORIZED | You're not authorized to edit this attribute |


## Permissions

| Permission                      | Description |
|---------------------------------|-------------|
| disk.create                     |             |
| disk.update                     |             |
| disk.show                       |             |
| disk.remove                     |             |
| disk.attributes.id.show         |             |
| disk.attributes.name.show       |             |
| disk.attributes.name.fill       |             |
| disk.attributes.driver.show     |             |
| disk.attributes.driver.fill     |             |
| disk.attributes.enabled.show    |             |
| disk.attributes.enabled.fill    |             |
| disk.attributes.config.show     |             |
| disk.attributes.config.fill     |             |
| disk.attributes.created_at.show |             |
| disk.attributes.updated_at.show |             |