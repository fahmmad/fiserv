# Fiserv - Test Application

- Application imports data from a text file and feed to the table during the first launch. 
- Search feature returns records from the database

## Setup
- Clone the repository
- Cope .env.example to .env
- ```docker compose up -d```
- try http://localhost:8000


## Troubleshooting

### Table was not created
Use the create table script in the .docker/database/init/database-setup.sql file

### Cannot see any subfolders deeper than 4 levels
With the current scope of the project, the depth level is restricted to 4 at the moment.
