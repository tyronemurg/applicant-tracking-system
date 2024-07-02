# Installation

You can install the dependency package via composer and NPM:

```bash
composer install
```
```bash
npm install && npm run build
```

Create symbolic link from your public/storage
```bash
php artisan storage:link
```

Run Database Migration
```bash
php artisan migrate
```

Run Database Seeder to populate the database
```bash
php artisan db:seed
```

Generate Permissions 
```bash
php artisan permissions:sync -C -Y
```


if you experience slow loading, run this
```bash
php artisan icons:cache
```



# Pre-defined Access Credentials

###### SUPER USER
```
superuser@mail.com
password
```

> **Notes For Roles**
> 
> `Super Admin` - All permission is granted
> 
>`Admin` - All permission is granted, but not including the following:
>   - Impersonating user
> 
> `Standard` - All permission is granted, but not including the following permissions.
>  - delete
>  - restore

### Initial Route

> `Main Page` - {SERVER_IP}/login

> `Candidate Portal` - {SERVER_IP}/portal/candidate

> `Career Page` - {SERVER_IP}/career

## Features

| Location         | Feature                        | Status      |
|------------------|--------------------------------|-------------|
| Admin            | Job Opening                    | Implemented |
| Admin            | Job Candidates                 | Implemented |
| Admin            | Candidate Profile              | Implemented |
| Admin            | Department                     | Implemented |
| Admin            | Referrals                      | Implemented |
| Admin            | Users                          | Implemented |
| Admin            | Roles & Permission             | Implemented |
| Candidate Portal | Job Opening                    | Implemented |
| Candidate Portal | My Applied Job                 | Implemented |
| Candidate Portal | Saved Job                      | Implemented |
| Candidate Portal | My Resume                      | Implemented |
| Career Page      | Apply Job via Portal           | Implemented |
| Career Page      | Apply Job via Application Form | Implemented |


## Code of Conduct

In order to ensure that the OSSAdmiral community is welcoming to all, please review and abide by the [Code of Conduct](#).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail us. All security vulnerabilities will be promptly addressed.

## License

The OSSAdmiral-Recruit  is open-sourced software licensed under the [GNU AGPLv3](https://choosealicense.com/licenses/agpl-3.0/).
