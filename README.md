
# Dockerized Symfony App

Clone the project

```bash
  git clone https://github.com/Faez-B/symfony-easy-admin.git
```

Go to the project directory

```bash
  cd symfony-easy-admin
```
## Run Locally...

```bash
  cd app
```
### 1 - Composer installation

```bash
  composer install
```

### 2 - NPM installation

```bash
  npm install
  npm run build
```

### 3 - Start the server

```bash
  symfony serve
```

### 4 - Run the NPM script
  
  ```bash
    npm run watch
  ```

Go to ```127.0.0.1:8000```

## ...or Run with Docker
### 1 - Launch the containers

```bash
docker compose up --build -d
```

### 2 - Command line
```bash
# Makefile
make inside
```
Go to ```127.0.0.1```

### Either way
You should have the following folders in your project directory

```bash
  /public/build/
  /public/bundles/
  /vendor/
  /node_modules/
```

### Available routes
  
  ```bash
    /         : ROLE_USER
    /admin    : ROLE_ADMIN
    /login    : PUBLIC_ACCESS
    /register : PUBLIC_ACCESS
  ```
