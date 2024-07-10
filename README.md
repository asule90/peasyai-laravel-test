# Peasy.ai Laravel test

## development
using dev container, you can easily run this project just by using docker and vscode
using [karma-runner](karma-runner.github.io/6.4/dev/git-commit-msg.html) git commit convention


## Description
Sampling an element from json result:
<details>
  <summary>Json</summary>

  ```json
  {
    "gender": "female",
    "name": {
    "title": "Ms",
    "first": "Abbey",
    "last": "Clarke"
    },
    "location": {
    "street": {
        "number": 8388,
        "name": "Park Lane"
    },
    "city": "Portmarnock",
    "state": "Wicklow",
    "country": "Ireland",
    "postcode": 37431,
    "coordinates": {
        "latitude": "-3.8361",
        "longitude": "66.4098"
    },
    "timezone": {
        "offset": "-2:00",
        "description": "Mid-Atlantic"
    }
    },
    "email": "abbey.clarke@example.com",
    "login": {
    "uuid": "02c6d9cf-4d30-40bc-9a07-43bfc9dfe455",
    "username": "heavyelephant318",
    "password": "9876",
    "salt": "2macSXhN",
    "md5": "90cb7cb98fa0e49277f8d44431a887c9",
    "sha1": "ed8914a332251e15766b791e20605defda3aa02b",
    "sha256": "8322ca381e39c4fcc6cc76182a0089e4de99ecde9248ddeafe5df1e3e406dbb5"
    },
    "dob": {
    "date": "1986-09-27T16:30:46.337Z",
    "age": 37
    },
    "registered": {
    "date": "2021-06-25T15:47:21.217Z",
    "age": 3
    },
    "phone": "051-898-2339",
    "cell": "081-802-0396",
    "id": {
    "name": "PPS",
    "value": "1932412T"
    },
    "picture": {
    "large": "https://randomuser.me/api/portraits/women/74.jpg",
    "medium": "https://randomuser.me/api/portraits/med/women/74.jpg",
    "thumbnail": "https://randomuser.me/api/portraits/thumb/women/74.jpg"
    },
    "nat": "IE"
  }

  ```
</details>

assuming uuid is from login property