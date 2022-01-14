## GET: http://rest-api/api/users
retourne tous les users

### optional parameters => id, query
GET: http://rest-api/api/users?id=1
GET: http://rest-api/api/users?query=test

## POST: http://rest-api/api/users
### parameters => firstname, lastname

## PUT: http://rest-api/api/users?id=1
### parameters => firstname, lastname

## DELETE: http://rest-api/api/users?id=1

### Remarque
POST et PUT nécessitent tous les deux firstname et lastname, je n'ai pas ajouté la possibilité de rendre l'un ou l'autre optionnel pour ce test