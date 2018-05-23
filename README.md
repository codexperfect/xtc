WebService Content
==================

Token parameter should be provided in a separated file: `my_module.wsc.serve.wstoken.yml`

```
wscontent:
  serve_client:
    profile_name:
      token: 'this-is-my-private-token-1234567890'
```

> Private token should be kept private out of the Git repository: Make sure your `.gitignore` file includes this line:

```
*.wstoken.yml
```
