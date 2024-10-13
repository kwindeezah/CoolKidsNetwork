## Problem to be Solved

The goal of this task is to implement a solution that allows; users to register and automatically create a character, maintainers (admin) to manage user roles. As specified in the user story, users with different roles—Cool Kid, Cooler Kid, and Coolest Kid—must have varying levels of access to information about other users. Coolest Kids should be able to view all details, including emails and roles, while Cooler Kids should only have access to the names and countries. Cool Kids should not have access to other users' details.

## Technical Specification of the Design

1. **Character Login Mechanism**
Instead of using the default WordPress user authentication (wp_users), the system authenticates users via the wp_characters table. The custom function is_character_logged_in() checks whether the user is logged in by verifying the email in the session with the wp_characters table.

2. **Displaying Character Information**
Upon logging in, the user can view their own character details such as their first name, last name, country, email, and role. This data is fetched directly from the wp_characters table using the logged-in user's email.

3. **Role-based Access to Other Characters**

Based on the user’s role:
**Cooler Kid**: Can view the first name, last name, and country of all users.

**Coolest Kid**: Can view all users' first name, last name, email, role, and country.

**Cool Kid**: No access to view other users’ details.

This logic is handled by checking the user's role in the database and providing the corresponding view when the "**See Other Characters**" button is clicked.

4. **Button to View Other Characters**
Once logged in, the system determines the character's role a button labeled "See Other Characters" is displayed on the user’s dashboard. Upon clicking, the system presents a table of characters' data or informs the user if they do not have permission to view this information.

## Technical Decisions and Reasoning

**CoolKidsNetwork Custom Table Creator**: I implemented a custom plugin that creates the wp_characters table during plugin installation. This table includes fields such as first_name, last_name, email, role, and country. The table is created with an SQL CREATE TABLE statement executed using the WordPress $wpdb object. The decision to handle table creation during plugin activation ensures that the system is set up automatically and minimizes manual setup for the admin. This decision was made to ensure that the database is initialized with the proper structure for character management, keeping the data separate from WordPress’s core user table. The use of dbDelta() ensures that the table is created if it does not already exist and handles updates in the table structure if necessary.

**Custom Table for Characters**: I chose to store the user data in a custom wp_characters table instead of the default wp_users table to meet the requirement of separate authentication and data storage for characters, ensuring flexibility in managing character-specific attributes and roles, ensuring that the system remains scalable and tailored to the specific use case.

**Session Handling for Login**: To handle character authentication, I used PHP sessions ($_SESSION['email']) for storing the email of logged-in users. This allowed me to keep authentication independent from the default WordPress system while integrating smoothly with the custom table.

**Role-based Conditional Access**: The decision to implement a simple conditional check on user roles makes the system efficient. The logic restricts data visibility without complicating the UI or requiring additional data layers. This keeps the system lean and scalable for future modifications.

**Shortcode Usage**: To make the feature easily reusable and deployable across different pages in WordPress, I encapsulated the entire dashboard display functionality within a shortcode (coolkidsnetwork_user_dashboard). This improves modularity and allows the admin to place this functionality anywhere within the WordPress site.

## Achieving the Admin's Desired Outcome

**This solution meets the admin’s requirements by:**

**Providing Automatic Character Creation**: Users can register and get a character automatically created simply by providing an email address. An account is created for this email on the website.
A fake identity is generated and stored, representing the user’s character. This fake identity is composed of: First name, last name, country, email address, role.


**Providing Role-Specific Access**: Users with the "Cooler Kid" or "Coolest Kid" roles can see other characters' details, adhering strictly to the permissions defined in the user stories. The solution ensures users can only see what their roles permit.

**Independent User Authentication**: By using the custom wp_characters table for login, the system remains separate from WordPress's default authentication, which is important given the context of custom roles and characters.

**Efficient Data Management**: The solution efficiently retrieves character data using optimized SQL queries, minimizing load on the database while ensuring accurate and secure data presentation.