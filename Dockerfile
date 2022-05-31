FROM vulnerables/web-dvwa
RUN apt-get update
RUN apt-get install nano curl wget python3 -y
#COPY * /var/www/html/vulnerabilities/exec
ENTRYPOINT ["sh", "./main.sh"]
