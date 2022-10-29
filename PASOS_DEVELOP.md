# CREACIÓN DE APLICACIÓN


### 1. Crear tabla "user" y tabla "roles"
 
 ``` 
 CREATE TABLE `roles` (
    `id_role` int(11) NOT NULL AUTO_INCREMENT,
    `role` varchar(50) NOT NULL,
    PRIMARY KEY (`id_role`)
  ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4
 
 ```


  ```
  CREATE TABLE `user` (
    `id_user` int(11) NOT NULL AUTO_INCREMENT,
    `user_name` varchar(50) NOT NULL,
    `password` varchar(250) NOT NULL,
    `email` varchar(250) NOT NULL,
    `id_role` INT NOT NULL,
    PRIMARY KEY (`id_user`),
    CONSTRAINT `fk_user_role` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
  ```

### 2. Introducimos datos en la tabla "roles"

  ```
  INSERT INTO `roles` (`role`) VALUES
  ('ROLE_ADMIN'),
  ('ROLE_USER');
  ```
### 3. Introducimos un usuario
```
INSERT INTO `user` (`use_name`, `password`, `email`, `id_role`) VALUES ('admin', 'admin', 'admin@admin.com', 1);
```
## Creación página de registro
1. Crear vista de registro
2. Crear controlador para registro




