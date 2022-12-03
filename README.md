##YEARBOOK CMS SYSTEM
Deployment.

Install :
Composer
Xampp v. 8.1.0 above..

Rename file :
.env.example => .env

    Database Configuration Look like this.
    <!--

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=year_book
DB_USERNAME=root
DB_PASSWORD=

-->

--------------- Open Terminal within the project file ------------
#Commands -

     composer i

    -

    php artisan key:generate

    -

    php artisan migrate --seed
    <!-- If this command doesnt work -->
        -Go to localost/phpmyadmin.
        -Create a database  "year_book"
        -Then Rerun command.

    -

    php artisan serve


    <!-- The Local Server or URL -->
    http://localhost:8000



    Default Admin Credentials:

    admin@admin.com
    password
