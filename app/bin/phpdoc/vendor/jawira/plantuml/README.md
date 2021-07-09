PlantUML integration
====================

Provides [PlantUML](http://plantuml.com/) integration: **plantuml executable** and **plantuml.jar**.

<!--version:start-->
PlantUML Version 1.2021.8
<!--version:end-->

[![Latest Stable Version](https://poser.pugx.org/jawira/plantuml/v/stable)](https://packagist.org/packages/jawira/plantuml) 
[![Total Downloads](https://poser.pugx.org/jawira/plantuml/downloads)](https://packagist.org/packages/jawira/plantuml) 
[![License](https://poser.pugx.org/jawira/plantuml/license)](https://packagist.org/packages/jawira/plantuml)
[![composer.lock](https://poser.pugx.org/jawira/plantuml/composerlock)](https://packagist.org/packages/jawira/plantuml)
[![PHPPackages Referenced By](http://phppackages.org/p/jawira/plantuml/badge/referenced-by.svg)](http://phppackages.org/p/jawira/plantuml)
[![PDS Skeleton](https://img.shields.io/badge/pds-skeleton-blue.svg)](https://github.com/php-pds/skeleton)
[![Issues](https://img.shields.io/github/issues/jawira/plantuml.svg?label=HuBoard&color=694DC2)](https://huboard.com/jawira/plantuml)
[![HitCount](http://hits.dwyl.io/jawira/plantuml.svg)](http://hits.dwyl.io/jawira/plantuml)

Usage
-----

Check that PlantUML is working correctly:

```console
$ vendor/bin/plantuml -version
```

To generate a diagram:

```console
$ vendor/bin/plantuml /path/to/file.puml
```

By default _png_ image is created in same location as _puml_ file.

You also get access to **plantuml.jar**:

```console
$ java -jar ./vendor/jawira/plantuml/bin/plantuml.jar -version
```

Install
-------

Install using Composer:

```console
$ composer require --prefer-dist jawira/plantuml
```

Requirements
------------

PlantUML needs **Java Runtime** installed (see <http://plantuml.com/starting>).

On Ubuntu 18.04 you can run:

```console
$ sudo apt-get install -y  openjdk-11-jre
```

Checksum
--------

<!--version:start-->
PlantUML Version 1.2021.8
<!--version:end-->

File: [bin/plantuml.jar](bin/plantuml.jar)

| Algorithm | Checksum                                                                  |
| --------- | ------------------------------------------------------------------------- |
| md5       | <!--md5:start-->9efbd958040e0ac753a9a8b6d1c4dd0c<!--md5:end-->            |
| sha1      | <!--sha1:start-->934c25f077aa8624e6651d4fab01b995e82b1ba8<!--sha1:end-->  |

***

Packages from jawira
-----------------

<dl>

<dt><a href="https://packagist.org/packages/jawira/plantuml-encoding">jawira/plantuml-encoding</a></dt>
<dd>PlantUML encoding functions.</dd>

<dt><a href="https://packagist.org/packages/jawira/case-converter">jawira/case-converter</a></dt>
<dd> Convert strings between 12 naming conventions: Snake case, Camel case, Kebab case, Pascal case, Ada case, Train case, Cobol case, Macro case, Upper case, Lower case, Title case, and Sentence case.</dd>

</dl>
