<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## RestFul API

# /api/register
 
[POST] in body:
- name
- last_name
- email
- password

  Response: {"error":null,"result":{"token":"4|okqhx7dZGCmc0GgmpaToR1K9FAOIJUjeWFfHp1bG"}}

# /api/login
[POST] in body:
- email
- password

Response: {"error":null,"result":{"token":"4|okqhx7dZGCmc0GgmpaToR1K9FAOIJUjeWFfHp1bG"}}

# /api/logout
[GET] Authotization -> Bearer Token

Response: {"error":null,"result":{"data":"User Logout successfully."}}

# /api/create_event
[POST] Authotization -> Bearer Token

in body:
- title
- text

Response: {"error":null,"result":{"id":2,"title":"event2","text":"text event2"}}

# /api/events
[GET] Authotization -> Bearer Token

Response: {
"error": null,
"result": [
{
"id": 1,
"title": "title event",
"text": "text event",
"creator_id": 1,
"created_at": "2023-06-24T16:19:11.000000Z",
"updated_at": "2023-06-24T16:19:11.000000Z"
},
{
"id": 2,
"title": "event2",
"text": "text event2",
"creator_id": 1,
"created_at": "2023-06-24T17:16:11.000000Z",
"updated_at": "2023-06-24T17:16:11.000000Z"
}
]
}

# /api/participate/2 (participate/{event})
участие в событии

[GET] Authotization -> Bearer Token
{"error":null,"result":"success"}

# /api/remove_participant/2 (remove_participant/{event})
отмена участия в событии

[GET] Authotization -> Bearer Token
{"error":null,"result":"success"}

# /api/events/2 (events/{event})
удаление события создателем

[DELETE] Authotization -> Bearer Token
{"error":null,"result":"success"}
