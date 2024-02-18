# Guía de Ejecución de la Aplicación con Docker y Docker Compose

## Instalación de Docker en Windows

### Habilitar WSL 2

1. Abre PowerShell como Administrador y ejecuta:

   ```powershell
   dism.exe /online /enable-feature /featurename:Microsoft-Windows-Subsystem-Linux /all /norestart
   dism.exe /online /enable-feature /featurename:VirtualMachinePlatform /all /norestart
   ```

2. Reinicia tu computadora.

### Instalar el paquete de actualización del kernel de Linux para WSL 2

- Descarga y ejecuta el paquete de actualización desde la página oficial de Microsoft.

### Establecer WSL 2 como tu versión predeterminada

1. Abre PowerShell como Administrador y ejecuta:

   ```powershell
   wsl --set-default-version 2
   ```

### Instalar una distribución de Linux desde la Microsoft Store

- Abre Microsoft Store, busca tu distribución de Linux favorita (por ejemplo, Ubuntu), e instálala.

### Instalar Docker Desktop para Windows

- Descarga Docker Desktop desde la [página oficial de Docker](https://www.docker.com/products/docker-desktop/) e instala el programa.
- Asegúrate de seleccionar la opción para usar Docker con WSL 2 durante la instalación.

## Instalación de Docker en Linux

- Ejecuta los siguientes comandos para instalar Docker:

  ```bash
  sudo apt-get update
  sudo apt-get install apt-transport-https ca-certificates curl software-properties-common
  curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
  sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"
  sudo apt-get update
  sudo apt-get install docker-ce docker-ce-cli containerd.io
  ```

- Para instalar Docker Compose, ejecuta:

  ```bash
  sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
  sudo chmod +x /usr/local/bin/docker-compose
  ```

## Ejecutar la Aplicación con Docker Compose

### Preparar el archivo Dockerfile y docker-compose.yml

- Asegúrate de tener el `Dockerfile` y `docker-compose.yml` en el directorio correcto.

### Construir y ejecutar los contenedores

- Abre una terminal o PowerShell en el directorio de tus archivos y ejecuta:

  ```bash
  docker-compose up --build
  ```

### Acceder a la aplicación

- Navega a `http://localhost:8080` en tu navegador para acceder a la aplicación.

### Limpieza

- Para detener y remover los contenedores, ejecuta:

  ```bash
  docker-compose down -v
  ```
