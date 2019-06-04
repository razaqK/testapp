#[Documentation](https://documenter.getpostman.com/view/544062/S1TX2Hd9?version=latest)

### Using Docker to install.
 - Clone `git@github.com:razaqK/testapp.git`
 - Run `cd testapp`
 - Run `docker-compose up`. This command build the images and start the containers
 - On you browser go to [localhost:port](http://127.0.0.1:81)

### Run Test Manually
 - Run `docker exec -it saloodo bash`
 - Run command `./vendor/bin/simple-phpunit` 
 
### API Documentation
Check the api documentation [here](https://documenter.getpostman.com/view/544062/S1TX2Hd9?version=latest)

### Authorization

This uses JWT for authorizing user to the available resources.  

### Database
- kindly find sample `database` in the `data directory`

### Improvements
* Improve test coverage
* Introduce migration

