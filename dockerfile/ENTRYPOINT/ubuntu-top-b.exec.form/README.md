
# ENTRYPOINT exec form
ref: https://docs.docker.com/engine/reference/builder/#exec-form-entrypoint-example


**per eseguire override di ENTRYPOINT e  CMD usare il flag ```--entrypoint```, specificando eventuali argomenti DOPO il nome dell'immagine**
 
ad esempio:
 
```
docker run -it --rm --entrypoint /bin/bash <NOMEIMMAGINE>
docker run -it --rm --entrypoint /bin/bash <NOMEIMMAGINE> -c "ls -l"
```
**NOTA per git bash windows: a causa di MINGW64 gli slash vanno raddoppiati:**
https://stackoverflow.com/a/39858122
```
winpty docker run -it --rm --entrypoint //bin//bash <NOMEIMMAGINE>
winpty docker run -it --rm --entrypoint //bin//bash <NOMEIMMAGINE> -c "ls -l"
```

**Non è possibile eseguire l'override dei soli argomenti perchè nel docker file gli argomenti sono specificati direttamente in ENTRYPOINT:**

```
ENTRYPOINT [ "top", "-b" ]
```
