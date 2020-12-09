## Pre-requisites

- PHP (v7.3.4)
- Composer (v2.0)
- Node (v10.15.3)
- NPM (v6.4.1)


## How to run locally

### Run the back-end:
1- Run te following commands
```
git clone https://github.com/m7mdemad/News_website

cd News_website

composer install 
```


2- Copy '.env.example' and rename it to '.env'


3- In .env:
configure the database connections to connect to your database
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=newsappserver
DB_USERNAME=root
DB_PASSWORD=
```

configure the mail connections
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```

add your newapi.org key (just in case my key has expired)
```
NEWSAPI_KEY="Your key goes here"
```

4- Run te following command
```
php artisan serve
```

Now the server is running

### Run the front-end:


5- Run te following command
```
cd frontend_vue
 
npm install
```

6- open 'src/vue-apollo.js' and edit the port in the following line to your back-end port

```
const httpEndpoint = process.env.VUE_APP_GRAPHQL_HTTP || 'http://localhost:8000/graphql

//and replace this line:
  wsEndpoint: process.env.VUE_APP_GRAPHQL_WS || 'ws://localhost:8000/graphql',
// with:
  wsEndpoint: null,
```

7- Run te following command
```
npm run serve
```

9- The website is easy to use but a quick demo can be found under the name 'demo.mp4' to illustrate how to use the website.
