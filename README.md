# php_examples
PHP api and examples

# start server 

```
php -S localhost:8000 server.php
```

```
php -S localhost:8000 router.php
```

# Make petitions

```
curl http://localhost:8000?resource_type=books -v
```

```
curl http://localhost:8000?resource_type=books | jq
```


```curl -X 'POST' http://localhost:8000/books -d '{"title":" Harry Potter and the Goblet of Fire","id_author":1,"id_genre":2}' | jq
```