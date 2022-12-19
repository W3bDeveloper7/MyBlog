# MyBlog Project
## Installation

First clone the project.

```bash
git clone https://github.com/W3bDeveloper7/MyBlog.git
```

into to the project and run composer update

```
cd MyBlog
```
Here
```
composer update
```
Then
```
npm install
```
Now you’ll create a MySQL database and set up environment variables to give the application access to the database.

Let’s copy ``env.example`` to ``.env`` and update the database related variables

```
cp .env.example .env
```

Then use **my_blog12-19-22.sql** in ``/`` dir or run migrate

```
php artisan migrate --seed
```

Finally, execute the following command

```
php artisan storage:link
```

Now the project is ready, just run the server command if you are on local:
```
php artisan serve
```
Then
```
npm run dev
```
Any Questions: please feel free to message me @ amahmoud033@gmail.com ;)
