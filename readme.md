# Onset game platform

## Requirements

* docker
* docker-compose

## Installation

Generate your RSA keys and put it in `./api/config/jwt` 
as `private.pem` and `public.pem` approprietly.

## Development

```bash
docker-compose up -d
```

To start an assets watching (inside `app` container):

```bash
npm run watch
```

## Deployment

// TODO
