# Masaaq Quizzes Management System

This is a multi-tenancy project developed by Masaaq company to manage quizzes. The project uses a single database to handle multiple tenants. we use the [tenancyforlaravel](https://tenancyforlaravel.com/) package.

## Installation

Follow these steps to set up the project:

1. Clone the repository:
    ```sh
    git clone git@github.com:sezohessen/masaaq-quiz.git quiz
    ```

2. Change the repository origin to your custom repository:
    ```sh
    cd quiz
    git remote set-url origin YOUR_REPOSITORY_URL
    ```

3. Install the project dependencies:
    ```sh
    composer install
    ```

4. Copy the example environment configuration file:
    ```sh
    cp .env.example .env
    ```

5. Run the database migrations and seed the database:
    ```sh
    php artisan migrate --seed
    ```
6. You can access you central domain by visiting : `http://localhost:8000` and tenant domain (created by seeder) by visiting `http://test.localhost:8000` (this is changed depend on you env `APP_URL`) if you want to change central domain do not forget to change env `CENTRAL_DOMAIN`

    > Note: You can change the number of `attempts_records` (20 by default) before running the seeders (in the `config/application.php` file) so you can downloading 20k CSV files.
## User Roles

There are three types of users in the system:
- **Super Admin**: Has access to all features and can manage client owners.
- **Client Owner**: Has a dashboard and can log in only from the central domain with an account provided by the admin. he can create quizzes, see the attempts and download the attempts in CSV files.
- **Member**: Can subscribe, attempt, and see results of the quiz
## Queue Management

To manage the queue with priority, use the following command:
```sh
php artisan queue:work --queue=high,medium,low,default
```
# API Endpoints

Below are some of the available API endpoints for **Member interactions only**. You can import the provided Postman collection (`Massaq-Quiz.postman_collection.json`) to see the full documentation with examples for each request.  

## Authentication

- `/login` (POST)
- `/register` (POST)

## Quizzes

- `/quiz/get`
- `/quiz/result/{id}`
- `/quiz/attempts`
- `/quiz/show/{id}`
- `/quiz/begin-quiz`
- `/quiz/finish-quiz/{id}` (POST)
- `/quiz/subscribe/{id}` (POST)

## Running Tests

This project includes a **pipeline actions** that triggers on every push to the main branch. You can review the test results in GitHub Actions. before running tests you need to create DB for testing purpose (for now database name `assignment_blueprint_test`)

To run tests locally, use the following command:

```bash
./vendor/bin/pest
```

## Stress Testing

For stress testing, update the `APP_URL` in the `.env` file to your production domain and observe the results.

## Email and Google Calendar Setup

To attend quizzes via email, configure your mail settings in the `.env` file.

For Google Calendar integration :

1. Visit [Google API console](https://console.developers.google.com/apis) and click "Select a project" in the header.
2. Create a project and enable the Google Calendar API.
3. Setup your required scopes like :
    1. `.../auth/userinfo.email`.
    2. `.../auth/userinfo.profile`.
    3. `openid`.
    4. Google Calendar API	 `.../auth/calendar` **(Need verification when publishing the app)**.
3. Set up the required OAuth credentials (Client ID) and set the **Authorized redirect URL** like : `http://localhost:8000/oauthcallback` or your domain and attach `/oauthcallback`.
4. Upload the credentials file in the project’s configuration (`config/oauth-credentials.json`).
5. Add your Google account to the "Test users" list in the OAuth consent screen settings, as the project will be in testing status.
## Filament (Not finished yet)
You can checkout for branch `FilamentInitialize` and update composer. then you can login as client owner and see the dashboard panel. It not done yet
## Contributing

Contributions are welcome! Please follow the standard GitHub flow.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.
