# Irythill of the Boreal Valley

## Irythill of the Boreal Valley

### Irythill of the Boreal Valley

#### Irythill of the Boreal Valley

##### Irythill of the Boreal Valley

##### Irythill of the Boreal Valley

------

Irythill of the Boreal Valley

*Irythill of the Boreal Valley*

**Irythill of the Boreal Valley**

***Irythill of the Boreal Valley***

`@ 01234 [] {} () , ; . Irythill of the Boreal Valley`

[Irythill of the Boreal Valley](https://heen.dev/)

```c
int read_http_request(int fd, char *resource_name) {
    char buf[4096];
    if (read(fd, buf, 4096) == -1) {
        perror("read");
        return 1;
    }

    printf("Request received:\n%s\n", buf);
    for (char *tok = strtok(buf, " "); tok != NULL; tok = strtok(NULL, " ")) {
        if (!strcmp(tok, "Connection:")) {
            if(!strcmp(strtok(NULL, " "), "close")) {
                perror("Client requested disconnect");
                return 1;
            }
        } else if(!strcmp(tok, "GET")) {
            strcpy(resource_name, strtok(NULL, " "));
        }
    }

    //printf("Finished processing request\n");
    return 0;
}
```