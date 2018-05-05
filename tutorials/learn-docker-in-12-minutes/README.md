# Learn docker in 12 Minutes


source: https://youtu.be/YFl2mCHdv24

# workarounds per Windows/Docker toolbox/GitBash

* usare la sintassi :
    ```
    wimpty docker ...
    ```

    per errore:
    ```
    the input device is not a TTY.  If you are using mintty, try prefixing the command with 'winpty'
    ```
* prependere il path locale del volume con uno slash:
    ```
    wimpty docker run -it -v //c/Users/username/path/to/datavolume:/logs ubuntu //bin//bash
    wimpty docker run -it -v /${PWD}:/logs ubuntu //bin//bash
    ```
ref: https://github.com/docker/toolbox/issues/607 
