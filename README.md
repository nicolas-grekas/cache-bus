Demo for Symfony's PR [30572](https://github.com/symfony/symfony/pull/30572)
=============================

```sh
cd /path/to/your/symfony/fork
git fetch git@github.com:symfony/symfony refs/pull/30572/head:cache-bus
git checkout cache-bus

cd /path/to/your/fork/of/this/repo
composer install
/path/to/your/symfony/fork/link .
APP_ENV=prod symfony server:start -d
APP_ENV=prod bin/console messenger:consume -vv
firefox https://127.0.0.1:8000/demo
```

Requirement: a running server on `amqp://guest:guest@localhost:5672/%2f/messages`

Proof it works:

![Action](screencast.gif)
