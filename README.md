# demo-vulnerable-webserver

git clone https://github.com/andrefernandes86/demo-vulnerable-webserver.git

cd demo-vulnerable-webserver

docker build -t webserver .

docker run --rm -d --name webserver -p 80:80 webserver
