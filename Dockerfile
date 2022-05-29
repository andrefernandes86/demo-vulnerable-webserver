FROM vulnerables/web-dvwa
RUN apt-get update
RUN apt-get install curl wget python3 -y
#COPY /tmp/* /var/www/html/vulnerabilities/exec
ENTRYPOINT ["main.sh"]
