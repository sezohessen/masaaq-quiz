# Changelog

All notable changes to the "Masaaq Quizzes Management System" project will be documented in this file.

## [Unreleased]
- Deploy the application to a server of your choice.
- Ability to view quiz results for all members by tenant owner, you can use filament for this (not completed yet)
- Dockerize the application
## [Version 1.1.0] - 2024-06-15

### Added

- Integrated Google Calendar API to manage quiz reminders efficiently.
- Implemented the ability for users to save the Google access token for subsequent reminder requests without re-authorization.
- Enhanced reminder functionality to allow multiple reminders for a single quiz attempt.

### Added

- Registered new tenants successfully.
- Created two types of quizzes: in-time quizzes and out-of-time quizzes.
- Managed questions effectively.
- Managed choices efficiently.
- Registered new accounts for tenant members, keeping them separate from tenant owners.
- Implemented member login/logout functionality.
- Enabled subscription to quizzes for members.
- Set up reminders for members before quiz start times.
- Added attempts for quizzes for members.
- Implemented quiz taking via unique email links and email notifications.
- Provided the ability to view quiz results after completion.
- Sent result and correct answer emails to members after quiz completion.
- Sent notifications to tenant owners after a client takes a quiz.
- Implemented dashboards for:
    - Number of members
    - Attempts
    - Pass rate
    - Fail rate
    - Average score
    - Average time for in-time quizzes
- Enabled exporting quiz results for all members by tenant owners to CSV with filters, utilizing queues for efficient processing.
- Created a REST API for the application, documented using Postman.
- Wrote tests for the application using Pest.
- Wrote stress testing for the application using Pest.
- Wrote a README.md file for the application, explaining how to setup and run the application, and how to use the REST API with examples for every endpoint.
- Wrote a CHANGELOG.md file for the application, explaining the changes made to the application and the new features added.

## [Version 1.0.0] - 2024-06-13

### Added

- Central and tenant domain setup instructions in the README.
- User roles: Super Admin, Client Owner, and Member.
- Queue management command for priority queue handling.
- API endpoints for member interactions.
- Pipeline action for GitHub Actions.
- Testing instructions in the README.
- Stress testing guidelines in the README.
- Email setup instructions in the README.
- Contributing guidelines in the README.
- MIT License information in the README.

### Changed

- Updated testing instructions with the correct command.
- Enhanced stress testing guidelines in the README.
- Updated README with Filament dashboard panel information.
- Updated README with Google Calendar integration progress.
- Updated CONTRIBUTING.md with GitHub flow instructions.

### Removed

- Deprecated features or unused code.

