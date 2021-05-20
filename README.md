## General Notes:

1. Choose only one (Set A or Set B).
2. Use RESTful API routes.
3. You are free to design the interface on how the application would look like.
4. Plus points for designing SPA (Single Page Application).
5. API-based architecture (separate instance for the API and web application).
6. Fork this repository on your GitHub account.
7. Create your app.
8. Add an **installation-instruction.txt** to note the reviewer on how to install and setup your application.

---

## Set A

Using any PHP and front-end framework, create a web application that have the following features:

1. Post an article
    - Ability to publish or save the article as draft
2. Update an article
    - Ability to publish or save the article as draft
3. Delete an article
4. View a specific article
    - Only viewable if "published", otherwise display a 404 page
5. List all articles
    - Display only the following columns:
        - Title
            - Clickable to edit the article
        - URL
            - Display only the path name
            - Clickable to view the article. Only viewable if "published", otherwise display a 404 page
        - Date created
        - Date updated
        - Published
            - Display a check icon if published, otherwise none
    - Display only 10 rows per page (plus points if can be customized to display XX number of rows per page)

Fields that needs input:

1. Title
    - Rules:
        - Required
        - Max length of 255 characters only
        - Automatically saves to the url column of the table as slug-case
2. Cover Photo
    - Rules:
        - Required
        - Image should be in .jpg or .png extension only
        - Max filesize of 200kb
3. Content
    - Rules:
        - Required
        - No limit on max length
4. Tags
    - Rules:
        - Optional
        - Accepts alphanumeric characters only
        - Display as input tags
        - Max of 5 input per article

Not required but plus points for using:
1. Laravel framework
2. ReactJS or VueJS
3. ORM

---

## Set B

Using only native PHP (no framework), for the backend, that uses API based architecture (separate instance for the API and web application), and any front-end framework, create an application that has the following features:

1. Login
    - Rules:
        - Redirect to a dashboard page stating that login was successful
2. Registration
    - Rules:
        - Validate for existing users
        - Redirect to login page if success

Fields that needs input:

1. Login user
    - Username
        - Rules:
            - Required
            - Accepts alphanumeric characters only
            - Min of 5 characters in length
            - Max of 25 characters in length
    - Password
        - Rules:
            - Required
            - Min of 5 characters in length
            - Max of 50 characters in length
2. Registration
    - Email
        - Rules:
            - Required
            - Must be a valid email format
    - Username
        - Rules:
            - Required
            - Accepts alphanumeric characters only
            - Min of 5 characters in length
            - Max of 25 characters in length
    - Password
        - Rules:
            - Required
            - Min of 5 characters in length
            - Max of 50 characters in length

Not required but plus points for using:

1. ReactJS or VueJS

Good luck!"# laravel-vue" 
"# laravel-vue" 
