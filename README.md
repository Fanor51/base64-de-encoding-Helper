# base64-de-encoding-Helper (AWS Serverless Image Handler)
![PHP Linting](https://github.com/Fanor51/base64-de-encoding-Helper/actions/workflows/ci.yaml/badge.svg)

This small tool is developed and used for debugging Image URL´s from f.E.
an [AWS Serverless Image Handler](https://aws.amazon.com/de/solutions/implementations/serverless-image-handler/) which
use base64 encoded JSON Configs in their urls.
---
## Function Table

| Function        | Parameter - 1 | Parameter - 2 | Parameter - 3 |
| ------------- |:-------------:| -----:|-----:|
| app:EncodeCommand      | Raw Image | Configset without .json (config/json/) |n.A |
| app:DecodeCommand      | base64 string      |   Output more Infos in CLI |  Save config under "config/json"  |

---
## Install
A simple ``composer install`` on your machine and rename ``config/.env.dist`` to ``config/.env``.

---
## Example Calls

### app:EncodeCommand
Create an base64 encoded URL string from the config set 1666216668.
```
php app.php app:EncodeCommand c378c23b-aadd-4e57-9407-46b37447063b.jpg 1666216668 
```

### app:DecodeCommand
Decode the following URL String, print a Verbose output on the CLI and save the json config with the current timestamp as name under ``config/json/{currentTimestamp}.json``
```
php app.php app:DecodeCommand eyJrZXkiOiJjMzc4YzIzYi1hYWRkLTRlNTctOTQwNy00NmIzNzQ0NzA2M2IuanBnIiwib3V0cHV0Rm9ybWF0IjoianBlZyIsImVkaXRzIjp7InJlc2l6ZSI6eyJ3aWR0aCI6NTIyLCJoZWlnaHQiOjM5MSwiZml0IjoiaW5zaWRlIn0sImpwZWciOnsicXVhbGl0eSI6OTV9fX0
1 1
```

---
## Extended
* You can save any config with every name you want under ``config/json/{yourCustomName}.json`` and call it on the EncodeCommand for creating a test suite.
* You can add a CDN Url on your local private config/.env ``CLOUDFRONT_URL='''`` to get it printed on your CLI to fast navigate and test your new string.
* You can change the json config save path in your local private config/.env.