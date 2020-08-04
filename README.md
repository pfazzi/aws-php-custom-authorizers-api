This is a demo project showing how to implement a custom authenticator based on a JWT
with Serverless framework, PHP and Bref.

### Install and Deploy
```bash
$ make install
$ make deploy
```

### Test
Access to a public resource:
```bash
$ curl https://{app-id}.execute-api.{region}.amazonaws.com/dev/api/public
```
Access to a private resource and get the error message:
```bash
$ curl https://{app-id}.execute-api.{region}.amazonaws.com/dev/api/private
```
Login and get a JWT:
```bash
$ curl -X POST https://{app-id}.execute-api.{region}.amazonaws.com/dev/api/login
```
Access to a private resource:
```bash
$ curl -H "Authorization: Bearer <JWT>" ttps://{app-id}.execute-api.{region}.amazonaws.com/dev/api/private
```