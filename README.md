# book_mgmt_system
Practical Assessment for Laravel,Vue and ElasticSearch

Steps to Run the Application

1. git clone {{url}}
2. Run "composer install" (to install Laravel dependencies)
3. Run "npm install" (to install vue and npm dependencies)
4. Run "php artisan migrate" (to migrate all the tables in database)
5. Run "php artisan db:seed" (to add 100 dummy data from reference link)
6. Setup name of database in env file like DB_DATABASE=book_mgmt and SCOUT_DRIVER=database (for elastic search using laravel scout plugin)
7. Run "npm run watch" 
8. Run "php artisan serve"

# book_mgmt_system API Documentation

APIs that I used for this CRUD
1. GET : /api/books 
  ->Request Parameters : page,search
  ->Response : Paginate Object
  
2. Post : /api/books 
  ->Request Parameters : title,author,description,genre,image,isbn,published,publisher
  ->Response : Success response
  
3. Post : /api/update/books/{id} 
  ->Request Parameters : id,title,author,description,genre,image,isbn,published,publisher (image is not mandatory, if we upload than it will replace the older one)
  ->Response : Success response

4. Post : /api/destroy/books/{id}
  ->Request Parameters : id,
  ->Response : Success Response
  
# book_mgmt_system Notes

-> Store and Update has backend validation to store the data.
-> Here I used the Laravel scout elasticsearch
-> All the data is paginated
-> Data from seeder directly takes from this link : https://fakerapi.it/api/v1/books?_quantity=100 
