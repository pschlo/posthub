# Posthub

Posthub is a small German-language social network created as a school project.
It supports accounts, posts, profiles, following, and a personal timeline. The
original interface and application structure are intentionally preserved.

This repository is kept for fun and historical interest. It has not been
security-hardened for public production use.

## Run locally

Install [Docker](https://docs.docker.com/get-docker/), copy
[`compose.yml`](compose.yml) into an empty directory, and run:

```console
docker compose up
```

Open <http://localhost:8080> and create an account. The application initializes
the database automatically and stores it in a Docker volume.

## Container image

Pull requests verify that the image builds. Changes to `master` publish
`ghcr.io/pschlo/posthub:latest`.

The application image expects these environment variables:

- `POSTHUB_DB_HOST`
- `POSTHUB_DB_PORT` (defaults to `3306`)
- `POSTHUB_DB_NAME` (defaults to `posthub`)
- `POSTHUB_DB_USER` (defaults to `posthub`)
- `POSTHUB_DB_PASSWORD`
