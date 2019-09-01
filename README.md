[![Build Status](https://travis-ci.org/deveBrice/Budget-pro-project.svg?branch=master)](https://travis-ci.org/deveBrice/Budget-pro-project)

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

What things you need to install the software and how to install them?

- [Docker CE](https://www.docker.com/community-edition)
- [Docker Compose](https://docs.docker.com/compose/install)

### Install

- Faire composer install

#### Init

```bash
cp .env.dist .env
docker-compose up -d
docker-compose exec --user=application web bash
```
