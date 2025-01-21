## Hey there,

Welcome, and thanks for checking out the repository! I'm sure that you're much more than able to check everything out yourself, but just in case. I’ll keep things concise, and feel free to reach out if you have any questions or need further clarification.

> [!NOTE]  
> I believe that this codebase requires much further polishing and revision. Due to time constraints (2 hours), not everything I initially planned could be implemented. I appreciate your understanding.


## Table of Contents

- [Features Implemented](#features-implemented)
- [Setup Instructions](#setup-instructions)
- [Postman Collection](#postman-collection)
- [Sequence Diagram](#sequence-diagram)

## Features Implemented

- **Authentication Simulation**  
  A simple authentication system has been implemented. Note that token-based authentication is not included due to the lack of external packages like `Symfony`.

- **Database Relations**  
  Migrations are used to define relationships between entities.

- **DDD Architecture**  
  I have followed a Domain-Driven Design (DDD) approach to ensure separation of concerns, as outlined in the task description. While it introduced an additional mapping layer and seemed somewhat complex for the size of this project, I also lacked external libraries.

- **Minimal UI**  
  The `/checkout` endpoint provides a minimal UI where a discount code (sent via email) can be applied to update the total order price. The discount code is tracked and marked as used in the database.

## Setup Instructions

1. **Start the Database**  
   Run the following command to start the local database:

   ```bash
   docker-compose up -d
   ```

   The database will be accessible on port `3307`. You can modify the configuration if needed.

2. **Install Dependencies**  
   Install the necessary PHP dependencies:

   ```bash
   composer install
   ```

3. **Run Migrations**  
   Apply the migrations and reset the database:

   ```bash
   php artisan migrate:fresh
   ```

4. **Seed the Database**  
   Generate 10 sample products for testing:

   ```bash
   php artisan db:seed
   ```

5. **Test with an API Client**  
   Use any API client (e.g., Postman, Insomnia) to test the available endpoints.

## Postman Collection

To make testing easier, I’ve included a small Postman collection for testing the API endpoints. You can import the collection into Postman and use it to quickly send requests to the API.

The collection includes requests for:
1. Authenticating users
2. Creating and updating orders
3. Viewing orders and products

## Sequence Diagram

And here's a small sequence diagram illustrating the required actions to test the functionality:

![image](https://github.com/user-attachments/assets/93825145-1f53-4b67-b9b9-6d5f2f490432)

I hope this helps provide a clearer overview of this 'project'.
