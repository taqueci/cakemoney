# CakeMoney

CakeMoney is a simple household account book for my wife.
This application is implemented by CakePHP.

The way of booking is based on double-entry bookkeeping system.

*Read this in other languages: [English](README.md), [日本語](README.ja.md).*


## Requirements

CakeMoney requires MySQL as a database.

CakeMoney uses BoostCake and Search plugins, and bootstrap-datepicker.


## Installation

Clone the repository using git.

    $ git clone https://github.com/taqueci/cakemoney.git

Install BoostCake and Search plugins by using Composer.

    $ cd cakemoney
    $ composer install

Put `bootstrap-datepicker.js` into the directory `webroot/js`.

Execute the following SQL statements into your database.

    CREATE TABLE categories (
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      name VARCHAR(255) NOT NULL,
      account_id INT UNSIGNED NOT NULL,
      description TEXT DEFAULT NULL,
      PRIMARY KEY (id),
      UNIQUE KEY name (name)
    ) DEFAULT CHARSET=utf8;

    CREATE TABLE journals (
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      date date NOT NULL,
      debit_id INT UNSIGNED NOT NULL,
      credit_id INT UNSIGNED NOT NULL,
      amount INT NOT NULL,
      description TEXT DEFAULT NULL,
      asset INT NOT NULL,
      liability INT NOT NULL,
      income INT NOT NULL,
      expense INT NOT NULL,
      equity INT NOT NULL,
      created DATETIME NOT NULL,
      modified DATETIME NOT NULL,
      PRIMARY KEY (id),
      UNIQUE KEY id (id)
    ) DEFAULT CHARSET=utf8;

Finally, make a CakePHP's database configuration file `Config/database.php`.


## Usage

First, add categories.
Open "Categories" page from navigation bar and click "New Category" on the
right side of the page.
(Or access to http://www.example.com/cakemoney/categories/add)

In order to book giving and taking of money,
open "New Journal" on the right side of "Journals" page.
(Or access to http://www.example.com/cakemoney/journals/add)

If you want to know the summary, open "Reports" page.


## Licence

[MIT](https://github.com/taqueci/cakemoney/blob/master/LICENCE)


## Author

Takeshi Nakamura
