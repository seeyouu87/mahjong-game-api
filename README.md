# mahjong-game-api
This is an idea of sample API for a simple mahjong game. This API is for protyping/prove of concept only

## Setup
Simple clone the repository and import the mahjongtable.sql file into your mysql database.
The code files shall put under your preferred web server's Document root Directory for eg: `C:\xampp\htdocs`

## The API endpoints and sample calls are explained below: 

1. authentication and get JWT:
   **endpoint:** `http://localhost/codeigniter/user/auth`
   **method:** POST
   **header:** content-type: application/json
   **request body:** 
   ```json
   {"email":"test@test.com","password":"1234"}
   ```
   response: 
   ```json
   {
      "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InRlc3RAdGVzdC5jb20iLCJleHAiOjE0ODQzMjEyMzl9.cgxuAU7FQjMOJZCkM16Xw7TERCzO3SFbQUEnBl7EVwI"
   }
   ```
2. get game room list: 
   **endpoint:** `http://localhost/codeigniter/game?token=<TOKEN GENERATED FROM authentication>`
   **method:** GET
   **header:** content-type: application/json
   **sample call:**
   `http://localhost/codeigniter/game?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InRlc3RAdGVzdC5jb20iLCJleHAiOjE0ODQzMjEyMzl9.cgxuAU7FQjMOJZCkM16Xw7TERCzO3SFbQUEnBl7EVwI`
   **sample response:** 
   ```json
   [{"roomid":"1","roomlevel":"10","roompoints":"1000","roomname":"beginner room"},{"roomid":"2","roomlevel":"20","roompoints":"2000","roomname":"Intermediate Room"}]
   ```
3. get active game sessions:
   **endpoint:**  `http://localhost/codeigniter/gamesession?token=<TOKEN GENERATED FROM authentication>`
   **method:** GET
   **header:** content-type: application/json
   **sample call:** `http://localhost/codeigniter/gamesession?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InRlc3RAdGVzdC5jb20iLCJleHAiOjE0ODQzMjEyMzl9.cgxuAU7FQjMOJZCkM16Xw7TERCzO3SFbQUEnBl7EVwI`
   **sample response:** 
   ```json   
   [{"roomid":"1","userid":"1","isuseractive":"1","userlastactive":"2017-01-13 15:39:28","userjoined":"2017-01-13 15:39:28"},{"roomid":"1","userid":"1","isuseractive":"1","userlastactive":"2017-01-13 15:40:42","userjoined":"2017-01-13 15:40:42"}]
   ```
4. Player join game room:
   **endpoint:**  `http://localhost/codeigniter/gamesession/joinroom?token=<TOKEN GENERATED FROM authentication>`
   **method:** POST
   **header:** content-type: application/json
   **sample call:** `http://localhost/codeigniter/gamesession/joinroom?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InRlc3RAdGVzdC5jb20iLCJleHAiOjE0ODQzMjEyMzl9.cgxuAU7FQjMOJZCkM16Xw7TERCzO3SFbQUEnBl7EVwI`
   **sample request body:** 
   ```json  
   {"roomId":"1"}
   ```
   **sample response:** 
   ```json 
   {"joined":true}
   ```
5. Player leave game room: 
   **endpoint:**  `http://localhost/codeigniter/gamesession/leaveroom?token=<TOKEN GENERATED FROM authentication>`
   **method:** POST
   **header:** content-type: application/json
   **sample call:** `http://localhost/codeigniter/gamesession/leaveroom?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InRlc3RAdGVzdC5jb20iLCJleHAiOjE0ODQzMjEyMzl9.cgxuAU7FQjMOJZCkM16Xw7TERCzO3SFbQUEnBl7EVwI`
   **sample request body:** 
   ```json  
   {"roomId":"1"}
   ```
   **sample responose:** 
   ```json  
   {"left":true}
   ```
6. Refresh game session(this is to call every 0.5 second) to update the server player is still in game: 
   **endpoint:**  `http://localhost/codeigniter/gamesession/refreshsession?token=<TOKEN GENERATED FROM authentication>`
   **method:** POST
   **header:** content-type: application/json
   **sample call:** `http://localhost/codeigniter/gamesession/refreshsession?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InRlc3RAdGVzdC5jb20iLCJleHAiOjE0ODQzMjEyMzl9.cgxuAU7FQjMOJZCkM16Xw7TERCzO3SFbQUEnBl7EVwI`
   **sample request body:** 
   ```json  
   {"roomId":"1"}
   ```
   **sample responose:** 
   ```json  
   {"refreshed":true}
   ```
7. check whether the other 3 players on the same table are still active
   **endpoint:**  `http://localhost/codeigniter/gamesession/isuseractive?token=<TOKEN GENERATED FROM authentication>`
   **method:** POST
   **header:** content-type: application/json
   **sample call:** `http://localhost/codeigniter/gamesession/isuseractive?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InRlc3RAdGVzdC5jb20iLCJleHAiOjE0ODQzMjEyMzl9.cgxuAU7FQjMOJZCkM16Xw7TERCzO3SFbQUEnBl7EVwI`
   **sample request body:** 
   ```json 
   {"userId":["1","2","3"],"roomId":"1"}
   ```
   **sample response:** 
   ```json 
   {"1":true,"2":false,"3":false}
   ```
8. List available tables to join (which mean less than 4 players joined the table):
   **endpoint:**  `http://localhost/codeigniter/table?token=<TOKEN GENERATED FROM authentication>`
   **method:** GET
   **header:** content-type: application/json
   **sample call:** `http://localhost/codeigniter/table?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InRlc3RAdGVzdC5jb20iLCJleHAiOjE0ODQzMjEyMzl9.cgxuAU7FQjMOJZCkM16Xw7TERCzO3SFbQUEnBl7EVwI`
   **sample response:** 
   ```json 
   [{"tableid":"2","roomid":"1"}]
   ```
9. List all players who currently joined the table:
   **endpoint:**  `http://localhost/codeigniter/table/showplayers?token=<TOKEN GENERATED FROM authentication>`
   **method:** POST
   **header:** content-type: application/json
   **sample call:** `http://localhost/codeigniter/table/showplayers?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InRlc3RAdGVzdC5jb20iLCJleHAiOjE0ODQzMjEyMzl9.cgxuAU7FQjMOJZCkM16Xw7TERCzO3SFbQUEnBl7EVwI`
   **sample request body:** 
   ```json  
   {"roomId":"1","tableId":"1"}
   ```
   **sample response:** 
   ```json 
   [{"userid":"4"},{"userid":"1"},{"userid":"3"},{"userid":"6"}]
   ```
10. player create a table in game room, waiting for other players to join. once started, player status is 'waiting', need to press 'ready' button. once all 4 players pressed 'ready' button only can start game. once a table is created, api will return the info of table in json format
   **endpoint:**  `http://localhost/codeigniter/table/createtable?token=<TOKEN GENERATED FROM authentication>`
   **method:** POST
   **header:** content-type: application/json
   **sample call:** `http://localhost/codeigniter/table/createtable?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InRlc3RAdGVzdC5jb20iLCJleHAiOjE0ODQzMjEyMzl9.cgxuAU7FQjMOJZCkM16Xw7TERCzO3SFbQUEnBl7EVwI`
   **sample request body:** 
   ```json  
   {"roomId":"1"}
   ```
   **sample response:** 
   ```json 
   [{"tableid":"1","roomid":"1","userid":"1","userstatus":"waiting","useraction":null,"gametoken":null,"actiontime":"2017-01-13 18:06:28"}]
   ```
11. Join a table in the room which player is current inside. The API will check if the table has 4 players, then consider full: 
   **endpoint:**  `http://localhost/codeigniter/table/jointable?token=<TOKEN GENERATED FROM authentication>`
   **method:** POST
   **header:** content-type: application/json
   **sample call:** `http://localhost/codeigniter/table/jointable?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InRlc3RAdGVzdC5jb20iLCJleHAiOjE0ODQzMjEyMzl9.cgxuAU7FQjMOJZCkM16Xw7TERCzO3SFbQUEnBl7EVwI`
   **sample request body:** 
   ```json 
   {roomId":"1","tableId":"1"}
   ```
   **sample responose:** 
   ```json 
   {"joined":true}
   ```
   if full :
   ```json 
   {"joined":false}
   ```   
12. Leave the table in the room which player is current inside: 
   **endpoint:**  `http://localhost/codeigniter/table/leavetable?token=<TOKEN GENERATED FROM authentication>`
   **method:** POST
   **header:** content-type: application/json
   **sample call:** `http://localhost/codeigniter/table/leavetable?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InRlc3RAdGVzdC5jb20iLCJleHAiOjE0ODQzMjEyMzl9.cgxuAU7FQjMOJZCkM16Xw7TERCzO3SFbQUEnBl7EVwI`
   **sample request body:** 
   ```json 
   {"roomId":"1","tableId":"1"}
   ```
   **sample responose:** 
   ```json
   {"left":true}
   ```
13. update every move the player doing after joined the table, if only send userAction, API will also update just player action, this is for status like "Ready", "Waiting": 
   **endpoint:**  `http://localhost/codeigniter/table/useraction?token=<TOKEN GENERATED FROM authentication>`
   **method:** POST
   **header:** content-type: application/json
   **sample call:** `http://localhost/codeigniter/table/useraction?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InRlc3RAdGVzdC5jb20iLCJleHAiOjE0ODQzMjEyMzl9.cgxuAU7FQjMOJZCkM16Xw7TERCzO3SFbQUEnBl7EVwI`
   **sample request body:** 
   ```json 
   {"roomId":"1","tableId":"1","userAction":"ready"} or {"roomId":"1","tableId":"1","userAction":"throw","gameToken":"Zhong"}
   ```
   **sample response:** 
   ```json
   {"updated":true}
   ```