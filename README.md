# 🚀 Cube PHP / VueJs Starter Template

This template repository can help you out to make a new CubePHP + VueJS project

- [Cube](https://github.com/yonis-savary/cube) is a backend framework for PHP8+
- [VueJS](https://vuejs.org/) is a frontend backend for Javascript (bundled with vite in this template)


As this repository is a template, you can edit any file in it, every build step/tuning is included in the [`Docker`](./Docker) directory !

## Development

To start your development environment, launch

```sh
# Build / Start both backend/frontend
# (Both have volumes so you don't have to rebuild for each change)
make dev

# Shutdown backend/frontend
make down
```

By default, backend starts on port `8000`, and frontend on `8001`, you can change this in your `.env` with `BACKEND_PORT`,`FRONTEND_PORT` variables


## Production

Production environment don't have separated backend/frontend:
- Frontend is built through `npm run build`
- Frontend dist files are then supported by Cube's static server feature
- Two services runs (1 PHP-FPM, 1 Nginx)

To start your production environment:
```sh
# Build / Start application (backend+frontend hybrid)
make prod

# Shutdown application
make down
```


> [!TIP]
> Don't forget to uncomment `ENV=production` in your `.env`, otherwise your frontend won't be served

## Todo

- [ ] Some `make deploy` command that pull changes, rebuild the app and launch migrations

