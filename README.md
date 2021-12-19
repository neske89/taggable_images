# desygner-test-task



## Local setup

- Add 127.0.0.1 desygner.test to hosts file
- Run docker-compose up
- Check folder permissions based on operating system on testing machine

### Testing
#### Setup
Assign grants for desygner user to desygner_test database. MySQL root password is desygner. 
#### Running
Test should be run within desygner_task-php docker container.
- docker exec -it desygner_task-php bash
- ./vendor/bin/phpunit

### Postman collection
Postman collection was attached to submission email. In order to use postman, user should add Postman environment with variable BASE_URL=desygner.test.  
Local file should be attached in post call.

### Notes
- Approach with saving tags in a single field in `images table` and searching by `Like operator` was taken because results (as I concluded by researching Desygner's app) expected to return UNION between all tags.
If intersection was requested, different solution would be applied. 
- Providing `relevance` parameter (with any value) in `Images` call will sort results based on number of tags matched in single row. This query needs further optimisation.
- Code was tested with around 5 000 000 records in the database.
- User management was out of the scope for test project.

### ToDo - Possible optimisations:
- Download huge images in background and set up user notifications system
- Write all test cases
- Optimize `relevance` query
- If provider is required in search, segregate data by providers in multiple tables in order to narrow data set which needs to be searched.

  

