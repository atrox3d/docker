
# ENTRYPOINT exec form


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

**per  override CMD e annullare i suoi  argomenti:**
```
docker run -it --rm <imagename> ""
```
