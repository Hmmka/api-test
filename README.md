# api-test

This is a test assignment
## Prerequisites

- PHP7
- MySQL
- Apache with enabled rewrite mode. 
- Composer
- Git

## How to install
```
git clone git@github.com:Hmmka/api-test.git
cd api-test
composer install
```
Create a new .env file in the same folder where you have cloned the project. 
You have to fill this file with mysql credentials.

```
DB_HOST=localhost
DB_USER=your_user_name
DB_PASSWORD=users_password
DB_NAME=database_name
DB_PORT=3306
```

Open browser.
```
run install.php file.
http://localhost/install.php 
delete install.php from the project. 
```
The product table and some values would be created in the mysql database. (There is mysql dump db.sql if needed.)

## How to use
There are three parameters and five methods available in the API.
- {id} - integer
- name - string no longer than 100 chars.
- price - decimal with 2 digits

You are able to see the GET results in the browser, if you open the link http://localhost/product/{id}. 
However, you have to send methods and the body via headers to have an access to the create, update and delete options. 

###### Methods:

```
Return all products:
GET /product

Return a singe product by id:
GET /product/{id}

Create a new product:
POST /product

Request Method: POST
Request payload: { name: 'a new name of the product goes nere', price: 'a new price goes here' }

Update an existing product:
PUT /product/{id}

Request Method: PUT
Request payload: { name: 'a new name of the product goes nere', price: 'a new price goes here' }

Delete an existing product:
DELETE /person/{id}

Request Method: DELETE
```
---------------

Javascript example:

```
async function makeFetch() {
    let item = {};
    item.name = "Addidas trainings";
    item.price = 79,95;

    const response = await fetch(
        "http://localhost/product/",
        {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(item)
        }
    );
    const data = await response.json();
    console.log(data);
}
```

## For Developers

You could easily expand this API by creating new tables in the database and new Services. 
To create a new service you have to create a new class which should be extended from Services abstract class.
Run your new api service in the index.php. 


